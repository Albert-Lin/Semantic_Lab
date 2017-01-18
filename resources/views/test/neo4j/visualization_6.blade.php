<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

?>

<!doctype html>
<html>
		<head>
			<title>{{ $title }}</title>
		</head>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
		<style>

				html, body, .side-bar-block, .main-content{
						width: 100%;
						height: 100%;
						margin: 0px;
						padding: 0px;
				}

				html, body, .side-bar-block{
						background-color: #999;
						overflow-x: hidden;
						overflow-y: hidden;
				}

				.side-bar-block {
						font-family: monospace;
						color: #FFF;
						position: absolute;
						float: left;
				}

						.function-list{
								width: 60px;
								height: 100%;
								margin: 0px;
								padding: 0px;
								background-color: rgb(47, 53, 62);
						}

								.nav-pills>li, .nav-pills>li+li{
										width: 60px;
										height: 60px;
										border: 0px;
										margin: 0px;
										padding: 0px;
										background-color: rgb(47, 53, 62);
								}

								.nav-pills>li>a {
										width: 60px;
										height: 60px;
										border: 0px;
										padding: 0px;
										margin: 0px;
										border-radius: 0px;

										text-align: center;
										vertical-align: middle;
										line-height: 60px;
								}

								.nav-pills > li > a:hover{
										background-color: rgb(47, 53, 62) !important;
										color: #259d6d;
								}

								.nav-pills > li.active > a{
										background-color: #666 !important;
										/*color: #d43f3a;*/
								}

								.nav-pills > li.active > a:visited{
										/*background-color: #F00 !important;*/
										/*color: #d43f3a;*/
								}

						.function-info-box{
								width: calc(25% - 60px);
								height: 100%;
								background-color: #666;
								overflow-x: hidden;
								overflow-y: auto;
						}

								#function-title{
										width: 100%;
										height: 80px;
										margin: 0px;
										padding: 0px;
										font-size: 18px;
										text-align: center;
										vertical-align: middle;
										line-height: 80px; /*as same as the height of div*/
										background-color: #444;
								}

								#server-box{
										width: 95%;
										height: 180px;
										margin: 2.5%;
										padding: 0p;
								}

										#server_account, #server_password{
												z-index: 0;
										}

								#node-info-box{
										width: 95%;
										margin: 2.5%;
										padding: 0p;
								}

										table{
												box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
										}

												thead{
														font-weight: 900;
														background-color: rgb(47, 53, 62);
												}

				.main-content {
						width: calc(100% - 60px);
						background-color: #999;
						position: relative;
						float: right;
						transition: 1s;
				}

						#cypher-box{
								width: 98%;
								height: 70px;
								margin: 10px;
								padding: 0px;
								font-family: monospace;
								font-size: 18px;
								background-color: #FFF;
						}

								#cypher{
										width: 98%;
										height: 100%;
										margin: 0px;
										padding: 0px;
										border: 0px;
										resize: none;
										float: right;
										 outline:0px !important;
										 -webkit-appearance:none;
								}

						#svg-box{
								width: 98%;
								height: calc(96% - 70px);
								margin: 10px;
								padding: 0px;
								background-color: #999;
								overflow-x: hidden;
								overflow-y: auto;
						}

						.svg-header{
								height: 60px;
								margin: 0px;
								padding: 0px;
								vertical-align: middle;
								line-height: 60px;
								color: #2579a9;
								font-family: monospace;
								background-color: #DDD;
						}

								.svg-header-delete{
										width: 60px;
										height: 60px;
										margin: 0px;
										padding: 0px;
										text-align: center;
										vertical-align: middle;
										line-height: 60px;
										float: left;
										top: 0px;
										background-color: #BBB;
								}

								.svg-header-labe{
										height: 60px;
										margin: 0px;
										padding: 0px;
										float: left;
										background-color: #DDD;
								}

						svg{
								transition: 1s;
						}

						path.link {
								fill: none;
								stroke: #666;
								stroke-width: 1.5px;
						}

				.div-horizontal{
						float: left;
				}

				hr {
						display: block;
						margin-top: 0px;
						margin-bottom: 40px;
						margin-left: 20px;
						margin-right: 20px;
						border-style: groove;
						border-width: 1px;
				}

				.function-label{
						width: 60%;
						height: 30px;
						text-align: center;
						vertical-align: middle;
						line-height: 30px;
						background-color: #d43f3a;
						box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
				}

				.glyphicon{
						color: rgb(83, 185, 234);
				}

				.glyphicon-trash {
						font-size: 20px;
						color: #d43f3a;
				}

				.glyphicon-function{
						font-size: 20px;
						color: #259d6d;
				}


		</style>
		<!-- FOR JQUERY -->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
		<!-- FOR BOOTSTRAP -->
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
		<!-- FOR D3 -->
		<script src="http://d3js.org/d3.v3.js"></script>
		<!-- FOR Neo4J -->
		<script src="../../js/neo4j/lib/browser/neo4j-web.js"></script>
		<script type="text/javascript">

		// TEST QUERY:
		//===========================================================================
		// MATCH (n:Person) RETURN n LIMIT 5
		// MATCH rdf=(sub:Person)-[p]-(obj:Movie)-[p2]-(obj2:Person) RETURN rdf LIMIT 10



		// GLOBAL VARIABLE:
		//===========================================================================
		/**
		 * BasicAuth for Neo4J;
		 * @type type
		 */
		var authToken = neo4j.v1.auth.basic("neo4j", "root");
		/**
		 * Driver & session of Neo4J
		 * @type type
		 */
		var driver;
		var session;
		var transPills = "";
		var transStatus = "close";
		var d3Array = [];
		var svgIndex = 0;
		function transStatusEvent(){
				$('.nav-pills li a').click(function(){

						if(transStatus === "close"){
								$('.main-content').css('width', "75%");
								$('svg').css('width', '100%');
								transPills = this.href;
								transStatus = "open";
						}
						else if(this.href !== transPills && transStatus === "open"){
								transPills = this.href;
						}
						else if(this.href === transPills && transStatus === "open"){
								$('.main-content').css('width', "calc(100% - 60px)");
								$('svg').css('width', '100%');
								transPills = this.href;
								transStatus = "close";
						}

				});
		}



		// CLASS:
		//===========================================================================
		/**
		 * The JsonData Class, which save the cypher query result
		 * @param {Entity} entity
		 * @param {Predicate} predicate
		 * * @param {Group} group
		 * @returns {JsonData}
		 */
		function JsonData(entity, predicate, group){
			this.nodes = entity;
			this.links = predicate;
			this.groups = group;
		}

		/**
		 * The Entity class
		 * @param {Node} nodeObject
		 * @param {String} svgId
		 * @returns {Entity}
		 */
		function Entity(nodeObject, svgId){
				this.id = svgId+"_"+nodeObject.identity.low;
				this.originalId = nodeObject.identity.low;
				this.type = nodeObject.labels[0];
				this.properties = nodeObject.properties;
				this.groupId;
		}

		/**
		 * The Predicate class
		 * @param {QueryResult} queryResult the object for saving the result of query
		 * @param {Path} predicateObject
		 * @param {String} svgId
		 * @returns {Predicate}
		 */
		function Predicate(queryResult, predicateObject, svgId){
				this.id = svgId+"_"+predicateObject.identity.low;
				this.originalId = predicateObject.identity.low;
		//			this.subjectId = queryResult.entityMap["entity_"+predicateObject.start.low];
		//			this.objectId =  queryResult.entityMap["entity_"+predicateObject.end.low];
		//			this.subjectId = "entity_"+predicateObject.start.low;
		//			this.objectId =  "entity_"+predicateObject.end.low;
				this.subjectId = svgId+"_"+predicateObject.start.low;
				this.objectId =  svgId+"_"+predicateObject.end.low;
				this.type = predicateObject.type;
				this.properties = predicateObject.properties;
		}

		/**
		 *
		 * @param {Array} entityIdList
		 * @param {String|Number} index
		 * @param {String|Number} svgId
		 * @returns {Group}
		 */
		function Group(entityIdList, index, svgId){
				this.entityIdList = entityIdList;
				this.type = "Group";
				this.id = svgId+"_group_"+index;
		}

		/**
		 * The Query Result Class
		 * @returns {QueryResult}
		 */
		function QueryResult(){
				// All the entities (node) of the cypher query result
				this.entities = [];
				// A hash map of entities
				this.entityMap = [];
				// All the predicates (rekationship) of the cypher query result
				this.predicates = [];
				// A hash map of predicates
				this.predicateMap = [];

				this.groups = [];

				this.nodeResult = function(result, svgId){
						var entity = new Entity(result, svgId);
						this.entityMapInsert(entity);
				};

				this.entityMapInsert = function(entity){
						var hashId = "entity_"+entity.id;
						if(this.entityMap[hashId] === undefined){
								this.entities.push(entity);
								this.entityMap[hashId] = this.entities.length-1;
						}
				};

				this.pathResult = function(result, svgId){
						var pathLength = result.length;
						for(var i = 0; i < pathLength; i++){
							// variable initialize:
							var segment = result.segments[i];
							var entity0;
							var entity1;
							var predicate;

							// add value to variable:
							// for node (entity):
							entity0 = new Entity(segment.end, svgId);
							entity1 = new Entity(segment.start, svgId);
							this.entityMapInsert(entity0);
							this.entityMapInsert(entity1);

							// for relationship (predicate):
							predicate = new Predicate(this, segment.relationship, svgId);
							this.predicateMapInsert(predicate);
						}
				};

				this.predicateMapInsert = function(predicate){
						var hashId = "predicate_"+predicate.id;
						if(this.predicateMap[hashId] === undefined){
							this.predicates.push(predicate);
							this.predicateMap[hashId] = this.predicates.length;
						}
				};

				this.groupResult = function(svgId){
						// the algorithm of the node grouping ...

						// this is for testing: All nodes in same group:
						for(var x = 0; x < 1; x++){
										var entityList = [];
										if(this.entities.length > 0){
										for(var i = 0; i < this.entities.length; i++){
												var entityId = this.entities[i].id;
												entityList.push(this.entityMap["entity_"+entityId]);
												this.entities[i].groupId = svgId+"_group_"+this.groups.length;
										}
										this.groups.push(new Group(entityList, this.groups.length, svgId));
								}
						}
				};
		}


		// FUNCTION:
		//===========================================================================
		/**
		 * The function connected to the Neo4J
		 * @returns {undefined}
		 */
		function neo4jConnection(){
				var account = document.getElementById("server_account").value;
				var password = document.getElementById("server_password").value;
				authToken = neo4j.v1.auth.basic(account, password);
				driver = neo4j.v1.driver("bolt://localhost", authToken, {
						encrypted:false
				});
				session = driver.session();
		}

		/**
		 * The d3.js visualization function
		 * @param {JsonData} jsonData
		 * @param {String} cypher
		 * @returns {undefined}
		 */
		function D3(jsonData, cypher){
				var nodes = [];
				var links = [];
				var groups = [];

				var showingNodes = [];
				var showingLinks = [];
				var showingNodesMap = [];
				var linksMap = [];
				var duplicateMap = [];
				var svgId = "svg_"+svgIndex;
				svgIndex++;

				// Compute the distinct nodes from the links.
				for(var i = 0; i < jsonData.nodes.length; i++){
						nodes[i] = jsonData.nodes[i];
						nodes[i].name = defaultNodeName(jsonData.nodes[i]);
				}

				jsonData.links.forEach(function(link) {
						link.source = nodes[link.subjectId];
						link.target = nodes[link.objectId];
						link.pre = link.type;

						var subob = link.subjectId+"_"+link.objectId;
						var obsub = link.objectId+"_"+link.subjectId;
						if( duplicateMap[subob]  === undefined &&	duplicateMap[obsub]  === undefined ){
								// subob
								duplicateMap[subob] = 1;
								link.duplicate = duplicateMap[subob] ;
								link.duplicateMapIndex = subob;
						}
						else if( duplicateMap[subob]  !== undefined &&	duplicateMap[obsub]  !== undefined ){
								console.log("something go wrong");
						}
						else if( duplicateMap[subob]  !== undefined &&	duplicateMap[obsub]  === undefined ){
								// subob
								duplicateMap[subob]++;
								link.duplicate = duplicateMap[subob];
								link.duplicateMapIndex = subob;
						}
						else if( duplicateMap[subob]  === undefined &&	duplicateMap[obsub]  !== undefined ){
								// obsub
								duplicateMap[obsub]++;
								link.duplicate = duplicateMap[obsub];
								link.duplicateMapIndex = obsub;
						}

						links.push(link);
				});

				for(var i = 0; i < jsonData.groups.length; i++){
						groups.push(jsonData.groups[i]);
						showingNodes[i] = jsonData.groups[i];
						showingNodes[i].name = defaultNodeName(jsonData.groups[i]);
						showingNodesMap[jsonData.groups[i].id] = i;
				}


				var width = Number($("#svg-box").css("width").replace("px",""))*1.3;
				var height = Number($("#svg-box").css("height").replace("px",""))*0.90-60;

				var force = forceSystem("new");

				var zoom = d3.behavior.zoom()
						.scaleExtent([0.05, 5])
						.on("zoom", zoomed);

				var svgHeader = '<div class="svg-header">\n\
												<div class="svg-header-delete glyphicon glyphicon-trash" onclick="svgDelete('+(svgIndex-1)+')"></div>\n\
												 <div class="svg-header-label">> '+cypher+'</div>\n\
										</div>';
				d3.select("#svg-box").append("div").attr("id", svgId);
				$("#"+svgId).append(svgHeader);
				$(".svg-header").css('width', width);

				var svg = d3.select("#"+svgId)
						.append("svg")
						.attr("width", width)
						.attr("height", height)
						.append("g")
						.attr("transform", "translate(0,0)scale(1)")
						.call(zoom);

				var rect = svg.append("rect")
						.attr("width", width)
						.attr("height", height)
						.style("fill", "rgb(47, 53, 62)")
						.style("pointer-events", "all");

				var container = svg.append("g");


				// build the arrow.
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

				appendPattern(container, "Person", svgId, "/image/person.png");
				appendPattern(container, "Location", svgId, "/image/location.png");
				appendPattern(container, "Car", svgId, "/image/car.png");
				appendPattern(container, "Movie", svgId, "/image/movie.png");
				appendPattern(container, "Group", svgId, "/image/group.png");

				var drag = dragSystem();

				var path = linesDom(container.append("g").attr("id", "LINKS"));

				var line = lineContent();

				// add the text
				var lineText = lineContentText();

				// define the nodes
				var node = nodeDom(container.append("g").attr("id", "NODES"));

				// add the nodes
				nodeContent(svgId);




				// add the curvy lines
				function tick() {
					line.attr("d", function(d) {
						var dx = d.target.x - d.source.x,
								dy = d.target.y - d.source.y,
								// the the degree of curvy line
								//dr = Math.sqrt(dx * dx + dy * dy);
								dr = Math.sqrt(dx * dx * 100 + dy * dy);
								
						var orientation = 0;
						var long = dr;
						var short = 0;
						var duplicateNum = duplicateMap[ d.duplicateMapIndex ];
						if(duplicateNum > 1){
								var mean = 0;
								if(duplicateNum%2 === 1){
										mean = Math.round(duplicateNum/2);
										if(d.duplicate < mean){
//												short = (mean-d.duplicate) * 0.02;
												if(Math.abs(d.source.x-d.target.x) > Math.abs(d.source.y-d.target.y)){
														short = (mean-d.duplicate)*dr*10;
												}
												else{
														long = (mean-d.duplicate)*dr*2;
														short = dr;
												}
										}
										else if(d.duplicate > mean){
//												short = (d.duplicate-mean) * 0.02;
												if(Math.abs(d.source.x-d.target.x) > Math.abs(d.source.y-d.target.y)){
														short = (d.duplicate-mean)*dr*10;
												}
												else{
														long = (d.duplicate-mean)*dr*1.5;
														short = dr;
												}
												orientation = 1;
										}
								}
								else if(duplicateNum%2 === 0){
										mean = duplicateNum/2;
										if(d.duplicate <= mean){
//												short = (mean-d.duplicate+1) * 0.02;
												if(Math.abs(d.source.x-d.target.x) > Math.abs(d.source.y-d.target.y)){
														short = (mean-d.duplicate+1)*dr*10;
												}
												else{
														long = (mean-d.duplicate+1)*dr*1.5;
														short = dr;
												}
										}
										else if(d.duplicate > mean){
//												short = (d.duplicate-mean) * 0.02;
												if(Math.abs(d.source.x-d.target.x) > Math.abs(d.source.y-d.target.y)){
														short = (d.duplicate-mean)*dr*10;
												}
												else{
														long = (d.duplicate-mean)*dr*1.5;
														short = dr;
												}
												orientation = 1;
										}
								}

						}

						return "M "+
								d.source.x+" "+d.source.y+
								" A "+long+" "+short+", 0 0 "+orientation+" "+
								d.target.x + " " +d.target.y;

//						return "M" +
//								d.source.x + "," +
//								d.source.y + "A" +
//								long + " " + short + ", 0 0 " +orientation+
//								d.target.x + " " +
//								d.target.y;
					});

					lineText.attr("x", function(d){
						return (d.source.x + d.target.x)/2;
					});
					lineText.attr("y", function(d){
						return (d.source.y + d.target.y)/2;
					});

					node.attr("transform", function(d) {
						return "translate(" + d.x + "," + d.y + ")";
					});
				}

				// Events && Actions:
				function zoomed() {
					container.attr("transform", "translate(" + d3.event.translate + ")scale(" + d3.event.scale + ")");
				}

				function nodeClick(d){
					var type = d.type;
					if(type === "Group"){
						groupExpansion(d);
					}
					else{

//						tableObjectProperty(d,type);

						var button = '<div  class="btn-group"><button  value="'+d.groupId+'" type="button" class="btn btn-info groupBtn">Regrouping</buton>';
						var expansionBtn = '<button  id="expansionBtn" type="button" class="btn btn-info">Expansion</buton></div>';
//						var info = "&nbsp&nbsp&nbspID:&nbsp"+d.originalId+"&nbsp&nbsp&nbsp&nbsptype:&nbsp"+type;
						var info = "<br>";
						info += tableObjectProperty(d,type)+button+expansionBtn;

						$("#node-info-box").html(info);

						$(".groupBtn").click(function(){
							$("#node-info-box").html("<br><br><br><br>");
								reGrouping(d.groupId);
						});

						$("#expansionBtn").click(function(){
								nodeExpansion(d.originalId, svgId, d.groupId);
						});
					}
				}

				function lineClick(d){
					var subjectOrigId = d.subjectId.split("_")[2];
					var objectOrigId = d.objectId.split("_")[2];
					var info = "&nbsp&nbsp&nbspID:&nbsp"+d.originalId+"&nbsp&nbsp&nbsp&nbspCypher: ("+subjectOrigId+")-["+d.type+"]-("+objectOrigId+")";
					document.getElementById("info").innerHTML = info;
				}

				function dblclick(d) {
					d3.select(this).classed("fixed", d.fixed = false);
				}

				function dragstarted(d) {
					d3.event.sourceEvent.stopPropagation();
				}

				function dragged(d) {
					d3.select(this).attr("transform", function(d) {
						return "translate(" + d.x + "," + d.y + ")";
					});
					d3.select(this).classed("fixed", d.fixed = true);
				}

				/**
				 * D3 Force System for all nodes and paths
				 * @param {String} type
				 * @returns {unresolved}
				 */
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

				function dragSystem(){
					return force.drag()
						.on("dragstart", dragstarted)
						.on("drag", dragged);
				}

				// Node:
				function nodeDom(parentDom){
					parentDom.selectAll(".node").remove("g");

					return parentDom.selectAll(".node")
							.data(force.nodes())
							.enter().append("g")
							.attr("class", "node")
							.attr("id", function(d){
									return d.id;
							})
							.attr("group", function(d){
								var groupId = d.groupId;
								if(groupId !== undefined){
									return groupId;
								}
								else{
									return "root";
								}
							})
							.call(drag)
							.on("dblclick", dblclick)
							.on("click", nodeClick);
				}

				function nodeContent(svgId){
					// add the nodes
					node.append("circle")
					.attr("fill", function(d){
							var type = d.type;
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
					})
					.attr("r", 26);

					// add the text
					node.append("text")
					.attr("x", -26)
					.attr("y", 45)
					.text(function(d){return d.name; })
					.style("font-size", "14px")
					.style("fill", function(d){
							var type = d.type;
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
					});
				}

				function defaultNodeName(entity){
					var type = entity.type;
					if(type === "Group"){
								var idElements = entity.id.split("_");
								return idElements[2]+"_"+idElements[3];
					}
					else if(type === "Movie"){
								return entity.properties.title;
					}
					else if(type === "人" ){
								return entity.properties.姓名;
					}
					else if(type === "Person" ){
								return entity.properties.name;
					}
					else if(type === "Location" || type === "地址" ){
								return entity.properties.地址;
					}
					else if(type === "Car" || type === "車牌號碼" ){
								return entity.properties.號碼;
					}
				}

				function nodeExpansion(nodeId, svgId, groupId){
					// get the cypher which user type
					var cypher = "MATCH rdf=(s)-[p]-(o) WHERE ID(s)="+nodeId+" RETURN rdf;";
					var queryResult = new QueryResult();

					// connect to the Neo4J
					neo4jConnection();
					session
						.run(cypher)
						.subscribe({
							onNext: function(record){
								record.forEach(function( object ){
									// if the result is Node:
									if(object.start === undefined){
										queryResult.nodeResult(object, svgId);
									}
									// if the result is Path:
									else{
										queryResult.pathResult(object, svgId);
									}
								});
							},
							onCompleted: function(metadate){
								// set the json data for visualization
								var jsonData = new JsonData(queryResult.entities, queryResult.predicates, queryResult.groups);
								// closed the session and driver of Neo4J
								session.close();
								driver.close();

								// main process add data into showingNodes and showingLink
								nodeExpsDataProcess(jsonData, groupId);
							}
						});
				}

				function nodeExpsDataProcess(jsonData, groupId){
					var expsNodeMap = [];
					// Compute the distinct nodes from the links.
					for(var i = 0; i < jsonData.nodes.length; i++){
						jsonData.nodes[i].name = defaultNodeName(jsonData.nodes[i]);
						jsonData.nodes[i].groupId = groupId;
						expsNodeMap[jsonData.nodes[i].id] = i;
						var exist = false;
						for(var j = 0; j < showingNodes.length; j++){
							if(showingNodes[j].id === jsonData.nodes[i].id){
								expsNodeMap[jsonData.nodes[i].id] = "s_"+j;
								exist = true;
								break;
							}
						}


						if(exist === false){
							showingNodes.push(jsonData.nodes[i]);
						}
					}


					jsonData.links.forEach(function(link) {
						var index = expsNodeMap[link.subjectId];
						if(index.toString().indexOf("s_") !== -1){
							index = index.split("_")[1];
							link.source = showingNodes[index];
						}
						else{
							link.source = jsonData.nodes[index];
						}


						index = expsNodeMap[link.objectId];
						if(index.toString().indexOf("s_") !== -1){
							index = index.split("_")[1];
							link.target = showingNodes[index];	
						}
						else{
							link.target = jsonData.nodes[index];
						}

						link.pre = link.type;

						var exist = false;
						for(var j = 0; j < showingLinks.length; j++){
							if(showingLinks[j].id === link.id){
								exist = true;
								break;
							}
						}


						if(exist === false){
							showingLinks.push(link);
						}
					});

					// reset the force system:
					force = forceSystem("reset");
					drag = dragSystem();
					// add the links and the arrows
					path = linesDom(container.select("#LINKS"));
					line = lineContent();
					lineText = lineContentText();	
					node = nodeDom(container.select("#NODES"));
					nodeContent(svgId);
				}



				// Line:
				function linesDom(parentDom){
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

				function lineContent(){
					return path.append("path")
							.attr("class", "link")
							.attr("marker-end", "url(#end"+(svgIndex-1)+")")
							.on("click", lineClick);
				}

				function lineContentText(){
					return path.append("text")
							.text(function(d) { return d.pre; })
							.style("fill", "rgb(254, 201, 97)")
							.style("font-size", "14px");
				}

				// SVG icon pattern:
				function appendPattern(container, idName, svgId, imgPath){
					container.append("pattern")
									.attr("id", idName+"_"+svgId)
									.attr("width", "5")
									.attr("height", "5")
									.append("image")
											.attr("href", imgPath)
											.attr("x", "0")
											.attr("y", "0")
											.attr("width", "52")
											.attr("height", "52");
				}


				// CAN WE USE THE HASH MAP METHOD TO DECREASE THE COMPUTING?
				function maping(entityId){
					var listIndex;
					for(var i = 0; i < showingNodes.length; i++){
						if(showingNodes[i].id === entityId){
							listIndex = i;
							break;
						}
					}
					return listIndex;
				}


				// Group:
				// Group expansion
				function groupExpansion(d){
					var entityIdList = d.entityIdList;
					// add the entities those in current group into showingNodes:
					for(var i = 0; i < entityIdList.length; i++){
						showingNodes.push(nodes[entityIdList[i]]);
//                showingNodesMap[nodes[entityIdList[i]].id] = -1;
					}

					// remove the current group out of showingNodes:
					for(var i = 0; i < force.nodes().length; i++){
						if(force.nodes()[i].id === d.id){
							force.nodes().splice(i, 1);
							showingNodesMap[d.id] = -1;
							// remove the svg element of the current group
							document.getElementById(d.id).innerHTML = "";
							document.getElementById(d.id).remove();

							break;
						}
					}

					// adding the links of the node which just insert into showingNodes
					// THIS MUST BE PREPROCESSING, TO DECREASE THE COMPUTING
					// 【========================================================================】
					for(var i = 0; i < force.nodes().length; i++){
						for(var j = 0; j < links.length; j++){
							if(nodes[entityIdList[i]].id === links[j].subjectId || nodes[entityIdList[i]].id === links[j].objectId){
								if(linksMap[links[j].id]  !== true){
									linksMap[links[j].id] = true;
									showingLinks.push(links[j]);
								}
							}
						}
					}
					// 【========================================================================】
					// reseting target:
					for(var i = 0; i < showingLinks.length; i++){
						showingLinks[i].source = showingNodes[ maping(showingLinks[i].subjectId) ];
						showingLinks[i].target = showingNodes[ maping(showingLinks[i].objectId) ];
					}

					// reset the force system:
					force = forceSystem("reset");
					drag = dragSystem();
					// add the links and the arrows
					path = linesDom(container.select("#LINKS"));
					line = lineContent();
					lineText = lineContentText();	
					node = nodeDom(container.select("#NODES"));
					nodeContent(svgId);
				}
				// Regrouping
				function reGrouping(groupId){
					var group;

					// find the Group object and add into showingNodes array
					for(var i = 0; i < groups.length; i++){
						if(groupId === groups[i].id){
							group = groups[i];
							showingNodes.push(group);
							break;
						}
					}

					// remove all entities which has same groupId
					for(var i = 0; i < force.nodes().length; i++){
						if(force.nodes()[i].groupId === groupId){
							var nodeId = force.nodes()[i].id;
							force.nodes().splice(i, 1);
	//            showingNodesMap[d.id] = -1;
							document.getElementById(nodeId).innerHTML = "";
							document.getElementById(nodeId).remove();
							i--;
						}
					}

					// remove all path which also belong to same groupId
					for(var i = 0; i < showingLinks.length; i++){
						if(showingLinks[i].source.groupId === groupId){
							linksMap[showingLinks[i].id] = false;
							showingLinks.splice(i, 1);
							i--;
						}
						else if(showingLinks[i].target.groupId === groupId){
							linksMap[showingLinks[i].id] = false;
							showingLinks.splice(i, 1);
							i--;
						}
					}
					$("."+groupId).html();
					$("."+groupId).remove();


					// reset the force system:
					force = forceSystem("reset");
					drag = dragSystem();
					// add the links and the arrows
					path = linesDom(container.select("#LINKS"));
					line = lineContent();
					lineText = lineContentText();	
					node = nodeDom(container.select("#NODES"));
					nodeContent(svgId);
				}
		}

		/**
		 * The only function which will worked after user execute the cypher query
		 * @returns {undefined}
		 */
		function main(){
			// get the cypher which user type
//			var svgId = "svg_"+document.getElementsByTagName("svg").length;
			var svgId = "svg_"+svgIndex;

			var cypher = document.getElementById("cypher").value;
			var queryResult = new QueryResult();

			// connect to the Neo4J
			neo4jConnection();
			session
				.run(cypher)
				.subscribe({
						// cypher query result preprocessing
						onNext: function(record) {
								record.forEach( function( object ) {
										// if the result is Node:
										if(object.start === undefined){
												queryResult.nodeResult(object, svgId);
										}
										// if the result is Path:
										else{
												queryResult.pathResult(object, svgId);
										}
								});
						},
						// the main work after preprocessing finished
						onCompleted: function(metadata) {
								queryResult.groupResult(svgId);
								// set the json data for visualization
								var jsonData = new JsonData(queryResult.entities, queryResult.predicates, queryResult.groups);

								// closed the session and driver of Neo4J
								session.close();
								driver.close();

								// start the d3.js visualization
								var d3 = D3(jsonData, cypher);
								d3Array[svgId] = d3;
						}
				});
		}

		/**
		 *
		 * @param {type} object
		 * @returns {undefined}
		 */
		function parsingObjectProperty(object){
				var result = "";
				for (var key in object.properties) {
					 result += "&nbsp&nbsp&nbsp&nbsp"+key+":&nbsp"+object.properties[key];
				}
				return result;
		}

		function tableObjectProperty(object, type){
				var result = '<table class="table">\n\
								<thead><tr> <td class="col-md-4">Property</td> <td class="col-md-8">Value</td> </tr></thead>';
				result += '<tbody><tr><td class="col-md-4">ID</td><td class="col-md-8">'+object.originalId+'</td></tr>';
				result += '<tr><td class="col-md-4">Type</td><td class="col-md-8">'+type+'</td></tr>';
				for (var key in object.properties) {
					 result += '<tr><td class="col-md-4">'+key+'</td><td class="col-md-8">'+object.properties[key]+'</td></tr>';
				}
				return result+"</tbody></table>";
		}

		function posNegRandom(){
				return Math.random()*10%2;
		}

		function svgDelete(svgId){
				d3Array[svgId] = undefined;
				$("#svg_"+svgId).html("");
				$("#svg_"+svgId).remove();

				if($("svg").length === 0){
						$("#node-info-box").html("");
				}
		}

		</script>
	<body onload="transStatusEvent()">

		<div class="side-bar-block">
				<div class="function-list div-horizontal" >
						<ul class="nav nav-pills">
								<li><a data-toggle="pill"  class="tabs glyphicon glyphicon-cog glyphicon-function" value="pills0"  href="#pills0"></a></li>
								<li><a data-toggle="pill"  class="tabs glyphicon glyphicon-barcode glyphicon-function" value="pills1"  href="#pills1"></a></li>
								<li><a data-toggle="pill"  class="tabs glyphicon glyphicon-leaf glyphicon-function" value="pills2"  href="#pills2"></a></li>
						</ul>
				</div>
				<div class="function-info-box div-horizontal">
						<div id="pills0" class="pills-content tab-pane fade">
								<!--FUNCTION TITLE-->
								<div id="function-title">
										FUNCTION TILE
								</div>
								<br>

								<!--SERVER BLOCK-->
								<div class="function-label">Server information</div>
								<div id="server-box">
										<br>
										<form class="form-horizontal">
												<div class="form-group">
														<div class="input-group col-sm-offset-1 col-sm-10">
															<span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
															<input id="server_account" class="form-control info" type="text" value="neo4j" placeholder="account"/>
														</div>
												</div>
												<div class="form-group">
														<div class="input-group col-sm-offset-1 col-sm-10">
															<span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
															<input id="server_password" class="form-control info" type="text" value="root" placeholder="password" />
														</div>
												</div>
										</form>
										<div class="col-sm-offset-0 col-sm-11">
												<button class="btn btn-info" onclick="main()">QUERY</button>
										</div>
								</div>
								<br>

								<!--NODE INFO-->
								<div class="function-label">Information of click</div>
								<div id="node-info-box">
										<br><br><br><br>
								</div>
								<br>

						</div>

						<div id="pills1" class="pills-content tab-pane fade"></div>

						<div id="pills2" class="pills-content tab-pane fade"></div>
				</div>
		</div>
		<div class="main-content">
				<div id="cypher-box"> <textarea id="cypher" >MATCH rdf=(s:Person)-[p]-(o:Movie) RETURN rdf LIMIT 15</textarea> </div>
				<div id="svg-box"></div>
		</div>

	</body>
</html>

