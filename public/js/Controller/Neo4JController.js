/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function Neo4JController(){

	var neo4jModel = new Neo4J();

	var SVG_INDEX;
	var SVG_ID;

	// var processObject = {
	// 	"nextFun": undefined,
	// 	"completedFun": undefined,
	// };

	// var d3Data = {
	// 		"svgId": "",
	// 		"svgIndex": "",
	// 		"nodes": [],
	// 		"links": [],
	// 		"groups": [],
	//
	// 		"showingNodes": [],
	// 		"showingLinks": []
	//
	// };
	//
	// var d3MappingData = {
	// 		"nodesMap": [],
	// 		"linksMap": [],
	// 		"duplicateMap": []
	// };


	// Model:
	//=======================================================
	/**
	 * Seting Neo4J server URI
	 * @param URI
	 */
	this.setServer = function(URI){
		neo4jModel.setServerURI(URI);
	};

	/**
	 * Main process for access Neo4J graph database,
	 * also call the function after access database.
	 * @param account
	 * @param password
	 * @param cypher
	 * @param processObject
	 */
	function mainProcess(account, password, cypher, processObject){
		neo4jModel.connection(account, password);
		neo4jModel.queryProcess(cypher, processObject);
	}

	/**
	 * Create a subscribe used object
	 * @returns {{nextFun: undefined, completedFun: undefined}}
	 * @constructor
	 */
	function Neo4jProcessObject(){
		return {
			"nextFun": undefined,
			"completedFun": undefined
		};
	}

	/**
	 * A general function for access Neo4J
	 * @param account : < View Class < HTML
	 * @param password : < D3 < HTML
	 * @param cypher
	 * @param fun : < View Class
	 * @param funParams : < View Class
	 */
	function serverQueryProcess(account, password, cypher, fun, funParams){

		// 00. initialize
		var processObject = Neo4jProcessObject();
		var d3Data = D3Data();
		var d3MappingData = D3MappingData();
		d3Data.svgIndex = SVG_INDEX;
		d3Data.svgId = SVG_ID;

		// 01. set actions for data pre-processing
		processObject.nextFun = function(records){
			// for all records
			records.forEach(function(singleRecord){
				D3VisEtl(d3Data, d3MappingData, singleRecord, SVG_ID);
			});

		};

		// 02. set actions for query completed
		processObject.completedFun = function(){
			fun(d3Data, d3MappingData, funParams);
		};


		// 03. query for result
		mainProcess(account, password, cypher, processObject);
	}

	// D3:
	//=======================================================

	/**
	 * Create a data object with D3 needs data format
	 * @returns {{svgId: string, svgIndex: string, nodes: Array, links: Array, groups: Array, showingNodes: Array, showingLinks: Array}}
	 * @constructor
	 */
	function D3Data(){
		return {
			"svgId": "",
			"svgIndex": "",
			"nodes": [],
			"links": [],
			"groups": [],

			"showingNodes": [],
			"showingLinks": []
		};
	}

	/**
	 * Create a hash map object with D3 needs data format
	 * @returns {{nodesMap: Array, linksMap: Array, duplicateMap: Array}}
	 * @constructor
	 */
	function D3MappingData(){
		return {
			"nodesMap": [],
			"linksMap": [],
			"duplicateMap": []
		};
	}

	/**
	 * The main function for connecting both Model(Neo4J) and View(D3 visualization)
	 * @param account : < D3 < HTML
	 * @param password : < D3 < HTML
	 * @param cypher : < D3 < HTML
	 * @param d3VisualizationFun : < D3
	 * @constructor
	 */
	this.D3Vis = function(account, password, cypher, d3VisualizationFun){
		// 00. D3 svg data initialization:
		var svgIndex = document.getElementsByTagName("svg").length;
		var svgId = "svg_"+svgIndex;
		var processObject = Neo4jProcessObject();
		var d3Data = D3Data();
		var d3MappingData = D3MappingData();

		d3Data.svgIndex = svgIndex.toString();
		d3Data.svgId = svgId;
		SVG_INDEX = svgIndex;
		SVG_ID = svgId;

		// 01. register all different functions for D3 to access Neo4J
		var funObject = {
			"expansionAllByNode": D3ExpansionAllByNode
		};

		// 02. set actions for data pre-processing
		processObject.nextFun = function(records){
			// for all records
			records.forEach(function(singleRecord){
				D3VisEtl(d3Data, d3MappingData, singleRecord, svgId);
			});

		};

		// 03. set actions for query completed
		processObject.completedFun = function(){
			// for all groups
			D3Grouping(d3Data, d3MappingData);
			d3VisualizationFun(d3Data, d3MappingData, cypher, funObject);
		};

		// 04. query for result
		mainProcess(account, password, cypher, processObject);
	};

	/**
	 * Main process of data ETL for D3 visualization
	 * @param d3Data
	 * @param d3MappingData
	 * @param object
	 * @param svgId
	 * @constructor
	 */
	function D3VisEtl(d3Data, d3MappingData, object, svgId){
		if(object.start === undefined){
			D3VisNodeEtl(d3Data, d3MappingData, object, svgId);
		}
		else{
			for(var i = 0; i < object.length; i++){
				var segment = object.segments[i];
				// for nodes
				D3VisNodeEtl(d3Data, d3MappingData, segment.end, svgId);
				D3VisNodeEtl(d3Data, d3MappingData, segment.start, svgId);

				// for relationship
				var hashId = "link_"+svgId+"_"+segment.relationship.identity.low;
				if(d3MappingData.linksMap[hashId] === undefined){
					var linkObject = {
						"originalId": segment.relationship.identity.low,
						"id": svgId+"_"+segment.relationship.identity.low,

						"subjectId": svgId+"_"+segment.relationship.start.low,
						"source": svgId+"_"+segment.relationship.start.low,

						"objectId": svgId+"_"+segment.relationship.end.low,
						"target":svgId+"_"+segment.relationship.end.low,

						"type": segment.relationship.type,
						"properties": segment.relationship.properties
					};
					D3DuplicateRelationship(d3MappingData.duplicateMap, linkObject);
					d3MappingData.linksMap[hashId] = d3Data.links.length;
					d3Data.links.push(linkObject);
				}
			}
		}
	}

	/**
	 * Special ETL process for D3 Node data
	 * @param d3Data
	 * @param d3MappingData
	 * @param object
	 * @param svgId
	 * @constructor
	 */
	function D3VisNodeEtl(d3Data, d3MappingData, object, svgId){
		var hashId = "node_"+svgId+"_"+object.identity.low;
		if(d3MappingData.nodesMap[hashId] === undefined){
			var nodeObject = {
				"originalId": object.identity.low,
				"id": svgId+"_"+object.identity.low,
				"type": object.labels[0],
				"properties": object.properties,
				"groupId": "",
				"name": D3NodeName(object.labels[0], object.properties)
			};
			d3MappingData.nodesMap[hashId] = d3Data.nodes.length;
			d3Data.nodes.push(nodeObject);
		}
	}

	/**
	 * Setting "name" property for D3 Node data
	 * @param type
	 * @param properties
	  * @param groupId
	 * @returns (String) {*}
	 * @constructor
	 */
	function D3NodeName(type, properties, groupId){
		if(type === "Group"){
			var idElements = groupId.split("_");
			return idElements[2]+"_"+idElements[3];
		}
		else if(type === "Movie"){
			return properties.title;
		}
		else if(type === "人" ){
			return properties.姓名;
		}
		else if(type === "Person" ){
			return properties.name;
		}
		else if(type === "Location" || type === "地址" ){
			return properties.地址;
		}
		else if(type === "Car" || type === "車牌號碼" ){
			return properties.號碼;
		}
	}

	/**
	 * Calculate number of relationships between two nodes
	 * @param duplicateMap
	 * @param object
	 * @constructor
	 */
	function D3DuplicateRelationship(duplicateMap, object){
		var subob = object.subjectId+"_"+object.objectId;
		var obsub = object.objectId+"_"+object.subjectId;
		if( duplicateMap[subob]  === undefined &&	duplicateMap[obsub]  === undefined ){
			// subob
			duplicateMap[subob] = 1;
			object.duplicate = duplicateMap[subob] ;
			object.duplicateMapIndex = subob;
		}
		else if( duplicateMap[subob]  !== undefined &&	duplicateMap[obsub]  !== undefined ){
			console.log("something go wrong");
		}
		else if( duplicateMap[subob]  !== undefined &&	duplicateMap[obsub]  === undefined ){
			// subob
			duplicateMap[subob]++;
			object.duplicate = duplicateMap[subob];
			object.duplicateMapIndex = subob;
		}
		else if( duplicateMap[subob]  === undefined &&	duplicateMap[obsub]  !== undefined ){
			// obsub
			duplicateMap[obsub]++;
			object.duplicate = duplicateMap[obsub];
			object.duplicateMapIndex = obsub;
		}
	}

	/**
	 * The algorithm for grouping nodes to several groups
	 * @param d3Data
	 * @param d3MappingData
	 * @constructor
	 */
	function D3Grouping(d3Data, d3MappingData){
		// only if the query result is not null
		if(d3Data.nodes.length > 0){
			// Grouping Algorithm:
			//
			// ...
			//

			// only for testing:
			for(var i = 0; i < 1; i++){
				var groupId = SVG_ID+"_group_"+d3Data.groups.length;
				var nodeList = [];
				for(var j = 0; j < d3Data.nodes.length; j++){
					// get the id of node should in current groups:
					var nodeId = d3Data.nodes[j].id;
					// in this testing example, "var indexOfList = j"
					var indexOfList = d3MappingData.nodesMap["node_"+nodeId];
					nodeList.push(indexOfList);

					// set the groupId of node;
					// in this testing example, "groupIp = svgId+'_group_'+i"
					d3Data.nodes[j].groupId = groupId;
				}

				var group = {
					"id": groupId,
					"nodeIdList": nodeList,
					"nodeList": nodeList,
					"type": "Group",
					"name": D3NodeName("Group", "", groupId)
				};

				d3Data.groups.push(group);
				d3Data.showingNodes.push(group);
			}
		}
	}

	/**
	 * Function for D3 visualization event
	 * @param account : < D3 < HTML
	 * @param password : < D3 < HTML
	 * @param nodeId : < D3
	 * @param groupId : < D3
	 * @param nodeExpansionDataProcess : < D3
	 */
	function D3ExpansionAllByNode(account, password, nodeId, groupId, nodeExpansionDataProcess){
		var cypher = "MATCH rdf=(s)-[p]-(o) WHERE ID(s)="+nodeId+" RETURN rdf;";
		serverQueryProcess(account, password, cypher, nodeExpansionDataProcess, {"groupId": groupId});
	}
}
