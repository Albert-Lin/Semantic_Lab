/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function Neo4J(){
	var imported = document.createElement('script');
	imported.src = '../../js/neo4j/lib/browser/neo4j-web.js';
	document.head.appendChild(imported);
	console.log("IN");
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
	 * A hash map of predicates
	 * @structure ["predicate_"+originalId] = predicate index of entity
	 * @type Array
	 */
	var predicateMap = [];
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
					D3();
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
			entityMapInsert(entity0);
			entityMapInsert(entity1);

			// for relationship (predicate):
			predicate = new Predicate(segment.relationship);
			predicateMapInsert(predicate);
		}
	}

	/**
	 * Insert node ID into entityMap
	 * @param {type} entity
	 * @returns {undefined}
	 */
	function entityMapInsert(entity){
		var hashId = "entity_"+entity.id;
		if(entityMap[hashId] === undefined){
			entities.push(entity);
			entityMap[hashId] = entities.length-1;
		}
	}
	/**
	 * Insert predicate ID into predicateMap
	 * @param {type} predicate
	 * @returns {undefined}
	 */
	function predicateMapInsert(predicate){
		var hashId = "predicate_"+predicate.id;
		if(predicateMap[hashId] === undefined){
			predicates.push(predicate);
			predicateMap[hashId] = predicates.length;
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

	function D3(){
		var nodes = {};
		var links = [];
		// Compute the distinct nodes from the links.
		jsonData.links.forEach(function(link) {
			link.source = nodes[link.subjectId] ||
					(nodes[link.subjectId] = {
						id: jsonData.nodes[link.subjectId].id,
						name: defaultNodeName(jsonData.nodes[link.subjectId]),
						type: jsonData.nodes[link.subjectId].type,
						properties: jsonData.nodes[link.subjectId].properties
					});
			link.target = nodes[link.objectId] ||
					(nodes[link.objectId] = {
						id: jsonData.nodes[link.objectId].id,
						name: defaultNodeName(jsonData.nodes[link.objectId]),
						type: jsonData.nodes[link.objectId].type,
						properties: jsonData.nodes[link.objectId].properties
					});
			link.pre = link.type;

			links.push(link);
		});


		var width = 1500;
		var height = 700;

		var force = d3.layout.force()
				.nodes(d3.values(nodes))
				.links(links)
				.size([width, height])
				.linkDistance(200)
				.charge(-1000) // the size of force system
				.on("tick", tick)
				.start();

		var zoom = d3.behavior.zoom()
				.scaleExtent([0.05, 5])
				.on("zoom", zoomed);

		var svgNum = document.getElementsByTagName("svg").length;

		var svg = d3.select("#svg").append("svg")
//					.attr("id", svgNum)
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
					.attr("id", String)
					.attr("viewBox", "0 -5 10 10")
					.attr("refX", 32)
					.attr("refY", 0)
					.attr("markerWidth", 8)
					.attr("markerHeight", 8)
					.attr("orient", "auto")
					.style("fill", "rgb(200, 200, 200)")
				.append("svg:path")
					.attr("d", "M0,-5L10,0L0,5");

		var drag = force.drag()
				.on("dragstart", dragstarted)
				.on("drag", dragged);

		// add the links and the arrows
		var path = container.append("g").selectAll("path")
				.data(force.links())
			.enter().append("g");

		var line = path.append("path")
				.attr("class", "link")
				.attr("marker-end", "url(#end)")
				.on("click", lineClick);

		// add the text
		var lineText = path.append("text")
			.text(function(d) { console.log(d); return d.pre; })
			.style("fill", "rgb(254, 201, 97)");

		// define the nodes
		var node = container.append("g").selectAll(".node")
				.data(force.nodes())
			.enter().append("g")
				.attr("class", "node")
				.call(drag)
				.on("dblclick", dblclick)
				.on("click", nodeClick);

		// add the nodes
		node.append("circle")
				.attr("fill", function(d){ return "url(#"+d.type+")"; })
				.attr("r", 26);

		// add the text
		node.append("text")
				.attr("x", -26)
				.attr("y", 45)
				.text(function(d) { return d.name; })
				.style("fill", function(d){
					var type = d.type;
					if(type === "Person"){
						return "rgb(243, 90, 95)";
					}
					else if(type === "Location"){
						return "rgb(107, 186, 243)";
					}
					else if(type === "Car"){
						return "rgb(167, 95, 239)";
					}
				});


		container.append("pattern")
				.attr("id", "Person")
				.attr("width", "5")
				.attr("height", "5")
				.append("image")
					.attr("href", "/image/person.png")
					.attr("x", "0")
					.attr("y", "0")
					.attr("width", "52")
					.attr("height", "52");

		container.append("pattern")
				.attr("id", "Location")
				.attr("width", "5")
				.attr("height", "5")
				.append("image")
					.attr("href", "/image/location.png")
					.attr("x", "0")
					.attr("y", "0")
					.attr("width", "52")
					.attr("height", "52");

		container.append("pattern")
				.attr("id", "Car")
				.attr("width", "5")
				.attr("height", "5")
				.append("image")
					.attr("href", "/image/car.png")
					.attr("x", "0")
					.attr("y", "0")
					.attr("width", "52")
					.attr("height", "52");

		container.append("pattern")
				.attr("id", "Movie")
				.attr("width", "5")
				.attr("height", "5")
				.append("image")
					.attr("href", "/image/movie.png")
					.attr("x", "0")
					.attr("y", "0")
					.attr("width", "52")
					.attr("height", "52");

		// add the curvy lines
		function tick() {
				line.attr("d", function(d) {
					var dx = d.target.x - d.source.x,
							dy = d.target.y - d.source.y,
							// the the degree of curvy line
							//dr = Math.sqrt(dx * dx + dy * dy);
							dr = Math.sqrt(dx * dx * 100 + dy * dy);

					return "M" +
							d.source.x + "," +
							d.source.y + "A" +
							dr + "," + dr + " 0 0,1 " +
							d.target.x + "," +
							d.target.y;
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

		function zoomed() {
		console.log("ZOOM 2");
			container.attr("transform", "translate(" + d3.event.translate + ")scale(" + d3.event.scale + ")");
		}

		function nodeClick(d){
			var info = "ID:"+d.id+"&nbsp&nbsp&nbsp&nbspNAME:"+d.name+"&nbsp&nbsp&nbsp&nbspTYPE:"+d.type;
			document.getElementById("info").innerHTML = info;
		}

		function lineClick(d){
			console.log("LINE");
			var info = "ID:"+d.id+"&nbsp&nbsp&nbsp&nbspCypher: ("+d.subjectId+")-["+d.type+"]-("+d.objectId+")";
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

		function defaultNodeName(entity){
			if(entity.type === "Movie"){
				return entity.properties.title;
			}
			else if(entity.type === "Person"){
				return entity.properties.name;
			}
		}
	}
}

