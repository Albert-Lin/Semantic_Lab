<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

?>

<!--<!doctype html>
<html>
    <head>
        <title>{{ $title }}</title>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
        <script src="http://d3js.org/d3.v3.min.js"></script>
        <script src="/js/test/d3/neo4j.js"></script>
    </head>
    <body onload="root()">

    </body>
</html>-->

<!--<++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++=>-->

<!doctype html>
<html>
	<head>
	<title>{{ $title }}</title>
	<meta charset="utf-8">
	<script src="http://d3js.org/d3.v3.js"></script>
	<style>
		path.link {
			fill: none;
			stroke: #666;
			stroke-width: 1.5px;
		}

		circle {
			/*fill: #ccc;*/
			/*stroke: #fff;*/
			/*stroke-width: 1.5px;*/
		}

		text {
			/*fill: #000;*/
			font: 10px sans-serif;
			pointer-events: none;
		}
	</style>
	<script>
		// get the data
		d3.json("/js/test/d3/force.json", function(error, jsonData) {
			var nodes = {};console.log(jsonData);
			// Compute the distinct nodes from the links.
			jsonData.links.forEach(function(link) {
				link.source = nodes[link.subjectId] ||
						(nodes[link.subjectId] = {
							id: jsonData.nodes[link.subjectId].id,
							name: jsonData.nodes[link.subjectId].name,
							type:jsonData.nodes[link.subjectId].type
						});
				link.target = nodes[link.objectId] ||
						(nodes[link.objectId] = {
							id: jsonData.nodes[link.objectId].id,
							name: jsonData.nodes[link.objectId].name,
							type:jsonData.nodes[link.objectId].type
						});
				link.pre = link.predicate;
			});

			var width = 1500;
			var height = 700;

			var force = d3.layout.force()
					.nodes(d3.values(nodes))
					.links(jsonData.links)
					.size([width, height])
					.linkDistance(200)
					.charge(-1000) // the size of force system
					.on("tick", tick)
					.start();

			var zoom = d3.behavior.zoom()
					.scaleExtent([0.05, 5])
					.on("zoom", zoomed);

			var svg = d3.select("body").append("svg")
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
				.text(function(d) { return d.pre; })
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
//					.attr("fill", "rgb(200, 200, 200)")
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

//			function mouseover() {
//				d3.select(this).select("circle").transition()
//						.duration(750)
//						.attr("r", 30);
//			}
//
//			function mouseout() {
//				d3.select(this).select("circle").transition()
//						.duration(750)
//						.attr("r", 26);
//			}

			function nodeClick(d){
				var info = "ID:"+d.id+"&nbsp&nbsp&nbsp&nbspNAME:"+d.name+"&nbsp&nbsp&nbsp&nbspTYPE:"+d.type;
				document.getElementById("info").innerHTML = info;
			}

			function lineClick(d){
				console.log("LINE");
				var info = "ID:"+d.id+"&nbsp&nbsp&nbsp&nbspCypher: ("+d.subjectId+")-["+d.predicate+"]-("+d.objectId+")";
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
});
	</script>
	<body>
		<div id="info">
			<br>
		</div>
	</body>
</html>