<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>

<!DOCTYPE html>
<meta charset="utf-8">
<a target="_blank" style="outline:none;">
<canvas width="960" height="960"></canvas></a>
<script src="https://d3js.org/d3.v4.min.js"></script>
<script>

var canvas = document.querySelector("canvas"),
    context = canvas.getContext("2d"),
    width = canvas.width,
    height = canvas.height,
    searchRadius = 40;

var color = d3.scaleOrdinal()
    .range(d3.schemeCategory20);

var simulation = d3.forceSimulation()
    .force("charge", d3.forceManyBody().strength(-18))
    .force("link", d3.forceLink().iterations(4).id(function(d) { return d.id; }))
    .force("x", d3.forceX())
    .force("y", d3.forceY());

d3.json("/js/test/d3/graph.json", function(error, graph) {
  if (error) throw error;

  var users = d3.nest()
      .key(function(d) { return d.user; })
      .entries(graph.nodes)
      .sort(function(a, b) { return b.values.length - a.values.length; });

  color.domain(users.map(function(d) { return d.key; }));

  simulation
      .nodes(graph.nodes)
      .on("tick", ticked);

  simulation.force("link")
      .links(graph.links);

  d3.select(canvas)
      .on("mousemove", mousemoved)
      .call(d3.drag()
          .container(canvas)
          .subject(dragsubject)
          .on("start", dragstarted)
          .on("drag", dragged)
          .on("end", dragended));

  function ticked() {
    context.clearRect(0, 0, width, height);
    context.save();
    context.translate(width / 2, height / 2);

    context.beginPath();
    graph.links.forEach(drawLink);
    context.strokeStyle = "#aaa";
    context.stroke();

    users.forEach(function(user) {
      context.beginPath();
      user.values.forEach(drawNode);
      context.fillStyle = color(user.key);
      context.fill();
    });

    context.restore();
  }

  function dragsubject() {
    return simulation.find(d3.event.x - width / 2, d3.event.y - height / 2, searchRadius);
  }

  function mousemoved() {
    var a = this.parentNode, m = d3.mouse(this), d = simulation.find(m[0] - width / 2, m[1] - height / 2, searchRadius);
    if (!d) return a.removeAttribute("href"), a.removeAttribute("title");
    a.setAttribute("href", "http://bl.ocks.org/" + (d.user ? d.user + "/" : "") + d.id);
    a.setAttribute("title", d.id + (d.user ? " by " + d.user : "") + (d.description ? "\n" + d.description : ""));
  }
});

function dragstarted() {
  if (!d3.event.active) simulation.alphaTarget(0.3).restart();
  d3.event.subject.fx = d3.event.subject.x;
  d3.event.subject.fy = d3.event.subject.y;
}

function dragged() {
  d3.event.subject.fx = d3.event.x;
  d3.event.subject.fy = d3.event.y;
}

function dragended() {
  if (!d3.event.active) simulation.alphaTarget(0);
  d3.event.subject.fx = null;
  d3.event.subject.fy = null;
}

function drawLink(d) {
  context.moveTo(d.source.x, d.source.y);
  context.lineTo(d.target.x, d.target.y);
}

function drawNode(d) {
  context.moveTo(d.x + 3, d.y);
  context.arc(d.x, d.y, 3, 0, 2 * Math.PI);
}

</script>