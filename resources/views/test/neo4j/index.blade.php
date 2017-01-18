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
	<script src="../js/neo4j/lib/browser/neo4j-web.js"></script>
	<script type="text/javascript">
		// MATCH (n:Person) RETURN n LIMIT 5
		// MATCH rdf=(sub:Person)-[p]-(obj:Movie)-[p2]-(obj2:Person) RETURN rdf LIMIT 10
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
		/**
		 * All the entities (node) of the cypher query result
		 * @type Array
		 */
		var entities = [];
		/**
		 * A hash map of entities
		 * @structure ["entity_"+originalId] = entities index of entity
		 * @type Array
		 */
		var entityMap = [];
		/**
		 * All the predicates (rekationship) of the cypher query result
		 * @type Array
		 */
		var predicates = [];
		/**
		 * The final json object of of the cypher query result
		 * @type type
		 */
		var jsonData = {
			nodes: [],
			links: []
		};

		// Functions:
		/**
		 * The only function which will worked after user execute the cypher query
		 * @returns {undefined}
		 */
		function main(){
			// connect to the Neo4J
			neo4jConnection();

			// get the cypher which user type
			var cypher = document.getElementById("cypher").value;
			session
				.run(cypher)
				.subscribe({
					// cypher query result preprocessing
					onNext: function(record) {
						record.forEach( function( object ) {
							// if the result is Node:
							if(object.start === undefined){
								nodeResult(object);
							}
							// if the result is Path:
							else{
								pathResult(object);
							}
						});
					},
					// the main work after preprocessing finished
					onCompleted: function(metadata) {
						// closed the session and driver of Neo4J
						session.close();
						driver.close();

						// set the json data for visualization
						jsonData.nodes = entities;
						jsonData.links = predicates;
						console.log(jsonData);
					}
				});
		}

		/**
		 * The function connected to the Neo4J
		 * @returns {undefined}
		 */
		function neo4jConnection(){
			driver = neo4j.v1.driver("bolt://localhost", authToken, {
					encrypted:false
			});
			session = driver.session();
		}

		/**
		 * Insert the entity object (Node) into the entities, also insert node ID into entityMap
		 * @param result cypher query result
		 * @returns {undefined}
		 */
		function nodeResult(result){
			var entity = new Entity(result);
			mapInsert(entity);
		}


		/**
		 * Insert the entity object (Node) into the entities,
		 *	insert node ID into entityMap
		 *	and insert predicate (Relationship) into predicates.
		 * @param result cypher query result
		 * @returns {undefined}
		 */
		function pathResult(result){
			var pathLength = result.length;
			for(var i = 0; i < pathLength; i++){
				// variable initialize:
				var segment = result.segments[i];
				var entity0;
				var entity1;
				var predicate;

				// add value to variable:
				// for node (entity):
				entity0 = new Entity(segment.end);
				entity1 = new Entity(segment.start);
				mapInsert(entity0);
				mapInsert(entity1);

				// for relationship (predicate):
				predicate = new Predicate(segment.relationship);
				predicates.push(predicate);
			}
		}

		/**
		 * Insert node ID into entityMap
		 * @param {type} entity
		 * @returns {undefined}
		 */
		function mapInsert(entity){
			var hashId = "entity_"+entity.id;
			if(entityMap[hashId] === undefined){
				entities.push(entity);
				entityMap[hashId] = entities.length-1;
			}
		}

		// Class:
		/**
		 * The Entity class
		 * @param {Node} nodeObject
		 * @returns {Entity}
		 */
		function Entity(nodeObject){
			this.id = nodeObject.identity.low;
			this.type = nodeObject.labels[0];
			this.properties = nodeObject.properties;
		}

		/**
		 * The Predicate class
		 * @param {type} predicateObject
		 * @returns {Predicate}
		 */
		function Predicate(predicateObject){
			this.id = predicateObject.identity.low;
			this.subjectId = entityMap["entity_"+predicateObject.start.low];
			this.objectId =  entityMap["entity_"+predicateObject.end.low];
			this.type = predicateObject.type;
			this.properties = predicateObject.properties;
		}

	</script>
	<body>
			<div id="cypherBox">
					<!--<input type="text" id="cypher" />-->
					<textarea id="cypher"></textarea>
					<input type="button" value="RUN > " onclick="main()"/>
			</div>
			<div id="infoBox"></div>
	</body>
</html>
