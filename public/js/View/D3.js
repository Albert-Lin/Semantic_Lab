/**
 * Created by AlbertLin on 2017/1/17.
 */

function D3(){

	this.linkedGraph = function(data, mappingData, cypher, controllerFuns){
		// data:
		var svgIndex = data.svgIndex;
		var svgId = data.svgId;
		var nodes = data.nodes;
		var links = data.links;
		var groups = data.groups;
		var showingNodes = data.showingNodes;
		var showingLinks = data.showingLinks;

		// mapping data (Hash Map):
		var nodesMap = mappingData.nodesMap;
		var linksMap = mappingData.linksMap;
		var duplicateMap = mappingData.duplicateMap;
		var showingNodesMap = [];
		var showingLinksMap = [];

		// D3 system:
		var force;
		var zoom;
		var drag;

		// DOM:
		var width = Number($("#svg-box").css("width").replace("px",""))*1.3;
		var height = Number($("#svg-box").css("height").replace("px",""))*0.90-60;
		var svgHeader = '<div class="svg-header">' +
						'<div class="svg-header-delete glyphicon glyphicon-trash" onclick="D3SvgDelete('+svgId+')"></div>' +
						'<div class="svg-header-label"> > '+cypher+'</div>' +
						'</div>';
		var svg;
		var rect;
		var container;
		var nodeDom; // node
		var nodeContent; // nodeContent(svgId)
		var linkDom; // path
		var linkPath; // line
		var linkText; // lineText

		initialization();

		// initialization
		function initialization(){
			// Mapping data:
			for(var i = 0; i < showingNodes.length; i++){
				var nodeId = showingNodes[i].id;
				showingNodesMap[nodeId] = true;
			}

			// D3:
			force = forceSystem("new");
			zoom = d3.behavior.zoom()
				.scaleExtent([0.05, 5])
				.on("zoom", zoomed);
			drag = dragSystem();

			// DOM:
			d3.select("#svg-box").append("div").attr("id", svgId).attr("style", "width:100%");
			$("#"+svgId).append(svgHeader);
			$(".svg-header").css('width', "100%");

			svg = d3.select("#"+svgId)
				.append("svg")
				.attr("width", width)
				.attr("height", height)
				.append("g")
				.attr("transform", "translate(0,0)scale(1)")
				.call(zoom);

			rect = svg.append("rect")
				.attr("style", "width:100%; height:100%;")
				.style("fill", "rgb(47, 53, 62)")
				.style("pointer-events", "all");

			container = svg.append("g");

			// for building arrow:
			container.append("defs").selectAll("marker")
				.data(["end"])      // Different link/path types can be defined here
				.enter().append("marker")    // This section adds in the arrows
				.attr("id", "end"+(svgIndex-1))
				.attr("viewBox", "0 -5 10 10")
				.attr("refX", 32)
				.attr("refY", 0)
				.attr("markerWidth", 8)
				.attr("markerHeight", 8)
				.attr("orient", "auto")
				.style("fill", "rgb(200, 200, 200)")
				.append("svg:path")
				.attr("d", "M0,-5L10,0L0,5");

			svgAppendPattern(container, "Person", svgId, "/image/person.png");
			svgAppendPattern(container, "Location", svgId, "/image/location.png");
			svgAppendPattern(container, "Car", svgId, "/image/car.png");
			svgAppendPattern(container, "Movie", svgId, "/image/movie.png");
			svgAppendPattern(container, "Group", svgId, "/image/group.png");

			linkDom = createLinkDom(container.append("g").attr("id", "LINKS"));
			linkPath = setlinkContent();
			linkText = setLinkText();

			nodeDom = createNodeDom(container.append("g").attr("id", "NODES"));
			nodeContent = setNodeContent();

		}

		// D3:
		function forceSystem(type){
			if(type === "new"){
				return new d3.layout.force()
					.nodes(showingNodes)
					.links(showingLinks)
					.size([width, height])
					.linkDistance(200)
					.charge(-1000) // the size of force system
					.on("tick", tick)
					.start();
			}
			else if(type === "reset"){
				if(force !== undefined){
					force.stop();
				}

				return d3.layout.force()
					.nodes(showingNodes)
					.links(showingLinks)
					.size([width, height])
					.linkDistance(200)
					.charge(-1000) // the size of force system
					.on("tick", tick)
					.start();
			}
		}

		function tick(){
			linkPath.attr("d", function(d){
				d.ori = -1; // for duplicate relationships between two nodes
				d.oriXY = -1; // if d.ori !== (-1), then we have to know the orientation for shift the text, if absX > absY, then the value of abxXY === 1, which means the text is shift in Y
				d.shiftSize = 0; // how many width or heigth needs to shift

				var dx = d.target.x - d.source.x;
				var dy = d.target.y - d.source.y;
				var dr = Math.sqrt(dx * dx * 100 + dy * dy);

				var orientation = 0;
				var long = dr;
				var short = 0;
				var duplicateNum = duplicateMap[ d.duplicateMapIndex ];
				var mean = 0;
				var absDuplicate = 0;
				var absX = Math.abs(dx);
				var absY = Math.abs(dy);

				if(duplicateNum > 1){
					if(duplicateNum%2 === 1){
						mean = Math.round(duplicateNum/2);
						absDuplicate = Math.abs(mean-d.duplicate);

						if(d.duplicate < mean && absX > absY){
							short = absDuplicate*dr*10;
							d.oriXY = 1;
							d.shiftSize = absDuplicate;
						}
						else if(d.duplicate < mean && absX <= absY){
							long = absDuplicate*dr*2;
							short = dr;
							d.oriXY = 0;
							d.shiftSize = absDuplicate;
						}
						else if(d.duplicate > mean && absX > absY){
							short = absDuplicate*dr*10;
							d.oriXY = 1;
							d.shiftSize = absDuplicate;
							orientation = 1;
						}
						else if(d.duplicate > mean && absX <= absY){
							long = absDuplicate*dr*1.5;
							short = dr;
							d.oriXY = 0;
							d.shiftSize = absDuplicate;
							orientation = 1;
						}
					}
					else if(duplicateNum%2 === 0){
						mean = duplicateNum/2;
						absDuplicate = Math.abs(mean-d.duplicate);

						if(d.duplicate <= mean && absX > absY){
							short = (absDuplicate+1)*dr*10;
							d.oriXY = 1;
							d.shiftSize = absDuplicate+1;
						}
						else if(d.duplicate <= mean && absX <= absY){
							long = (absDuplicate+1)*dr*1.5;
							short = dr;
							d.oriXY = 0;
							d.shiftSize = absDuplicate+1;
						}
						else if(d.duplicate > mean && absX > absY){
							short = absDuplicate*dr*10;
							d.oriXY = 1;
							d.shiftSize = absDuplicate;
							orientation = 1;
						}
						else if(d.duplicate > mean && absX <= absY){
							long = absDuplicate*dr*1.5;
							short = dr;
							d.oriXY = 0;
							d.shiftSize = absDuplicate;
							orientation = 1;
						}
					}
					d.ori = orientation;
				}

				return "M "+
					d.source.x+" "+d.source.y+
					" A "+long+" "+short+", 0 0 "+orientation+" "+
					d.target.x + " " +d.target.y;

			});

			linkText.attr("x", function(d){
				var x = (d.source.x + d.target.x)/2;
				if(d.oriXY === 0){
					if((d.source.y < d.target.y && d.ori === 0) || (d.source.y >= d.target.y && d.ori !== 0)){
						x -= d.shiftSize*45;
					}
					else{
						x += d.shiftSize*40;
					}
				}

				return x;
			});
			linkText.attr("y", function(d){
				var y = (d.source.y + d.target.y)/2;
				if(d.oriXY === 1){
					if((d.source.x < d.target.x && d.ori === 0) || (d.source.x >= d.target.x && d.ori !== 0)){
						y += d.shiftSize*40;
					}
					else{
						y -= d.shiftSize*40;
					}
				}

				return y;
			});

			nodeDom.attr("transform", function(d) {
				return "translate(" + d.x + "," + d.y + ")";
			});
		}

		function zoomed(){
			container.attr("transform", "translate(" + d3.event.translate + ")scale(" + d3.event.scale + ")");
		}

		function nodeClick(d){
			var type = d.type;
			if(type === "Group"){
				groupExpansion(d);
			}
			else{
				var info = "<br>";
				var propertyTable = keyValuesTable(d.properties, {"ID":d.originalId, "Type":d.type});
				// create html + bootstrap buttons for more actions:
				var regroupBtn = '<button  id="regroupBtn" type="button" class="btn btn-info groupBtn">Regrouping</buton>';
				var expansionBtn = '<button  id="expansionBtn" type="button" class="btn btn-info">Expansion</buton>';
				info += propertyTable+'<div  class="btn-groups">'+regroupBtn+expansionBtn+'</div>';
				$("#node-info-box").html(info);

				// register for button events:
				$("#regroupBtn").click(function(){
					$("#node-info-box").html("<br><br><br><br>");
					reGrouping(d.groupId);
				});

				$("#expansionBtn").click(function(){
					nodeExpansion(d.originalId, d.groupId);
				});
			}
		}

		function visualResetting(){
			force = forceSystem("reset");
			drag = dragSystem();
			// add the nodes, links and the arrows
			linkDom = createLinkDom(container.select("#LINKS"));
			linkPath = setlinkContent();
			linkText = setLinkText();
			nodeDom = createNodeDom(container.select("#NODES"));
			nodeContent = setNodeContent();
		}

		// dbclick
		function nodeDubleClick(d){
			d3.select(this).classed("fixed", d.fixed = false);
		}

		function dragSystem(){
			return force.drag()
				.on("dragstart", dragStarted)
				.on("drag", dragged);
		}

		function dragStarted(d){
			d3.event.sourceEvent.stopPropagation();
		}

		function dragged(d){
			d3.select(this).attr("transform", function(d) {
				return "translate(" + d.x + "," + d.y + ")";
			});
			d3.select(this).classed("fixed", d.fixed = true);
		}

		// lineClick
		function linkedClick(d){
			var subjectOrigId = d.subjectId.split("_")[2];
			var objectOrigId = d.objectId.split("_")[2];
			var info = {
				"Type": d.type,
				"RDF": "<"+subjectOrigId+"> <"+d.type+"> <"+objectOrigId+">."
			};
			var table = keyValuesTable(d.properties, info);
			$("#node-info-box").html("<br>"+table);
		}



		// Node:
		// nodeDom()
		function createNodeDom(parentDom){
			parentDom.selectAll(".node").remove("g");

			return parentDom.selectAll(".node")
				.data(force.nodes())
				.enter().append("g")
				.attr("class", "node")
				.attr("id", function(d){
					return d.id;
				})
				.attr("groups", function(d){
					if(d.groupId !== undefined){
						return d.groupId;
					}
					else{
						return "root";
					}
				})
				.call(drag)
				.on("dblclick", nodeDubleClick)
				.on("click", nodeClick);
		}

		// nodeContent()
		function setNodeContent(){
			// add the nodes
			nodeDom.append("circle")
				.attr("fill", function(d){
					return setTypeIcon(d.type);
				})
				.attr("r", 26); // 26 is for png which 256*256

			// add the text
			nodeDom.append("text")
				.attr("x", -26)
				.attr("y", 45)
				.text(function(d){return d.name; })
				.style("font-size", "14px")
				.style("fill", function(d){
					return setTypeColor(d.type);
				});
		}

		function nodeExpansion(nodeId, groupId){
			var account = $("#server_account").val();
			var password = $("#server_password").val();
			var expansionAllByNode = controllerFuns.expansionAllByNode;
			expansionAllByNode(account, password, nodeId, groupId, nodeExpansionDataProcess);
		}

		function nodeExpansionDataProcess(expData, expMappingData, params){
			// data:
			var expNodes = expData.nodes;
			var expLinks = expData.links;
			var expShowingNodes = expData.showingNodes;
			var expShowingLinks = expData.showingLinks;

			// mapping data (Hash Map):
			var expNodesMap = expMappingData.nodesMap;
			var expLinksMap = expMappingData.linksMap;
			var expDuplicateMap = expMappingData.duplicateMap;
			var expShowingLinksMap = [];

			// parameters:
			var groupId = params.groupId;

			// add all expansion nodes into showingNodes
			for(var i = 0; i < expNodes.length; i++){
				var nodeId = expNodes[i].id;
				if(showingNodesMap[nodeId] !== true){
					expNodes[i].groupId = groupId;
					showingNodes.push(expNodes[i]);
					showingNodesMap[nodeId] = true;
				}
			}

			// add all expansion links into showingLinks
			for(var i = 0; i < expLinks.length; i++){
				var linkId = expLinks[i].id;
				if(showingLinksMap[linkId] !== true){
					showingLinks.push(expLinks[i]);
					showingLinksMap[linkId] = true;
				}
			}

			$("."+groupId).html();
			$("."+groupId).remove();

			// reset the source and target of links
			for(var i = 0; i < showingLinks.length; i++){
				showingLinks[i].source = showingNodes[ mapping(showingLinks[i].subjectId) ];
				showingLinks[i].target = showingNodes[ mapping(showingLinks[i].objectId) ];
			}

			// visualize resetting:
			visualResetting();
		}



		// Line:
		// linesDom()
		function createLinkDom(parentDom){
			parentDom.selectAll("path").remove();
			parentDom.selectAll("text").remove();

			return parentDom.selectAll("path")
				.data(force.links())
				.enter().append("g")
				.attr("class", function(d){
					var subjectGroupId = d.source.groupId;
					var objectGroupId = d.target.groupId;
					return subjectGroupId+" "+objectGroupId;
				});
		}

		// lineContent()
		function setlinkContent(){
			return linkDom.append("path")
				.attr("class", "link")
				.attr("marker-end", "url(#end"+(svgIndex-1)+")")
				.on("click", linkedClick);
		}

		// lineContentText()
		function setLinkText(){
			return linkDom.append("text")
				.text(function(d) { return d.type; })
				.style("fill", "rgb(254, 201, 97)")
				.style("font-size", "14px")
				.on('click', linkedClick);
		}

		// NEEDS TO FIX:
		function mapping(nodeId){
			var listIndex;
			for(var i = 0; i < showingNodes.length; i++){
				if(showingNodes[i].id === nodeId){
					listIndex = i;
					break;
				}
			}
			return listIndex;
		}



		// Group:
		function groupExpansion(d){
			// get the node list of current group
			var nodeIdList = d.nodeIdList;

			// add the nodes in list into showingNodes
			for(var i = 0; i < nodeIdList.length; i++){
				var node = nodes[ nodeIdList[i] ]
				showingNodes.push( node );
				showingNodesMap[node.id] = true;
			}

			// remove the node of current group out of showingNodes && HTML DOM
			for(var i = 0; i < showingNodes.length; i++){
				if( showingNodes[i].id === d.id ){
					showingNodesMap[d.id] = false;
					showingNodes.splice(i, 1);
					$("#"+d.id).html("");
					$("#"+d.id).remove();

					break;
				}
			}

			// add all links which belong to current group
			// FIX: CHANGE TO HASH MAP TECH.
			//==================================================================
			for(var i = 0; i < nodeIdList.length; i++){
				var nodeId = nodeIdList[i];
				for(var j = 0; j < links.length; j++){
					// get the links should add:
					if(nodes[nodeId].id === links[j].subjectId || nodes[nodeId].id === links[j].subjectId){
						// check the link is exist in showingLinks before adding
						var linkId = links[j].id;
						if(showingLinksMap[linkId] !== true){
							showingLinksMap[linkId] = true;
							showingLinks.push(links[j]);
						}
					}
				}
			}
			//==================================================================

			// reset the source and target of links
			for(var i = 0; i < showingLinks.length; i++){
				showingLinks[i].source = showingNodes[ mapping(showingLinks[i].subjectId) ];
				showingLinks[i].target = showingNodes[ mapping(showingLinks[i].objectId) ];
			}

			// visualize resetting:
			visualResetting();
		}

		function reGrouping(groupId){

			// get the group with groupId && add into showingNodes
			for(var i = 0; i < groups.length; i++){
				if(groups[i].id === groupId){
					showingNodes.push(groups[i]);
					showingNodesMap[groupId] = true;
					break;
				}
			}

			// remove all nodes in showingNodes && DOM that belong to the group
			for(var i = 0; i < showingNodes.length; i++){
				if(showingNodes[i].groupId === groupId){
					var nodeId = showingNodes[i].id;
					showingNodesMap[nodeId] = false;
					showingNodes.splice(i, 1);
					$("#"+nodeId).html("");
					$("#"+nodeId).remove();
					i--;
				}
			}

			// remove all links in showingLinks && DOM that belong to the group
			for(var i = 0; i < showingLinks.length; i++){
				var linkId = showingLinks[i].id;
				if(showingLinks[i].source.groupId === groupId || showingLinks[i].target.groupId === groupId){
					showingLinksMap[linkId] = false;
					showingLinks.splice(i, 1);
					i--;
				}
			}
			$("."+groupId).html();
			$("."+groupId).remove();


			// visualize resetting:
			visualResetting();
		}


		// svg visualization:
		function setTypeIcon(type){
			if(type === "Group"){
				return "url(#Group_"+svgId+")";
			}
			else if(type === "Person" || type === "人" ){
				return "url(#Person_"+svgId+")";
			}
			else if(type === "Location" || type === "地址" ){
				return "url(#Location_"+svgId+")";
			}
			else if(type === "Car" || type === "車牌號碼" ){
				return "url(#Car_"+svgId+")";
			}
			else if(type === "Movie"){
				return "url(#Movie_"+svgId+")";
			}
		}

		function setTypeColor(type){
			if(type === "Group"){
				return "rgb(255, 157, 38)";
			}
			else if(type === "Person" || type === "人" ){
				return "rgb(243, 90, 95)";
			}
			else if(type === "Location" || type === "地址" ){
				return "rgb(107, 186, 243)";
			}
			else if(type === "Car" || type === "車牌號碼" ){
				return "rgb(167, 95, 239)";
			}
			else if(type === "Movie"){
				return "rgb(15, 200, 75)";
			}
		}

	};

}