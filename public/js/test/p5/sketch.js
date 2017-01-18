/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

var nodeArray = [];

function setup(){
	createCanvas($(window).width(), $(window).height());
	stroke(255);
	frameRate(60);
	dataInit();
}

function draw(){
	background(255);
	for(var i = 0; i < 10; i++){
		nodeArray[ i ].update();
	}
}


function dataInit(){
	for(var i = 0; i < 10; i++){
		nodeArray[ i ] = new Node(i);
	}
}

function Node(index){
	this.index = index;
	this.pos = createVector(random(0, width), random(0, height));
	this.r = random(20, 60);
	this.stop = 0.995;
	this.movingVector = createVector(random(-1, 1), random(-1, 1));

	this.update = function(){
		if(dist(mouseX, mouseY, this.pos.x, this.pos.y) < this.r){
			// stop this node
		}
		else{
			var cVector = createVector(this.pos.x, this.pos.y);
			var newVector = createVector(this.movingVector.x*this.r, this.movingVector.y*this.r);
			cVector.add(newVector);
			if(cVector.x <= 0 || cVector.x >= width || cVector.y <= 0 || cVector.y >= height ){
				this.movingVector = createVector(random(-1, 1), random(-1, 1));
			}
			this.pos.add(this.movingVector);
			this.movingVector = createVector(this.movingVector.x*this.stop, this.movingVector.y*this.stop);
		}
		text(index, this.pos.x, this.pos.y+this.r+5);
		ellipse(this.pos.x, this.pos.y, this.r, this.r);
		fill(234, 56, 158, 150);
	};
}

function mouseDragged(){
	for(var i = 0; i < 10; i++){
		var x = nodeArray[ i ].pos.x;
		var y = nodeArray[ i ].pos.y;

		if(dist(mouseX, mouseY, x, y) < nodeArray[ i ].r){
			nodeArray[ i ].pos.x = mouseX;
			nodeArray[ i ].pos.y = mouseY;
		}
	}
}