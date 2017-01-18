/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

// GLOBAL VARIABLE:
var jsonData;
var nodeArray = [];
var relationshipArray = [];
var focusIndex;
var personIcon;
var locationIcon;
var pressX;
var pressY;

// P5 DEFINED FUNCTION :
function preload() {
	var jsonURL = 'http://semantic_lab/js/test/p5/json/node.json';
	jsonData = loadJSON(jsonURL);
	var personURL = 'http://semantic_lab/image/person.png';
	personIcon = loadImage(personURL);
	var locationURL = 'http://semantic_lab/image/location.png';
	locationIcon = loadImage(locationURL);
}

function setup(){
	createCanvas(windowWidth, windowHeight);
	dataInit();
	frameRate(60);
}

function draw(){
	background(47, 53, 62);
	for(var i = 0; i < relationshipArray.length; i++){
		relationshipArray[i].update();
	}

	for(var i = 0; i < nodeArray.length; i++){
		nodeArray[i].update();
	}
}


// GLOBAL FUNCTION :
function dataInit(){
	// create nodes:
	for(var i = 0; i < jsonData.node.length; i++){
		var id = jsonData.node[i].id;
		var className = jsonData.node[i].class;
		var name = jsonData.node[i].name;
		var url = jsonData.node[i].url;
		nodeArray[i] = new Node(id, className, name, i, url);
	}

	// create relationships:
	for(var i =  0; i < jsonData.relationship.length; i++){
		var id = jsonData.relationship[i].id;
		var subject = jsonData.relationship[i].subject;
		var predicate = jsonData.relationship[i].predicate;
		var object = jsonData.relationship[i].object;
		var url = jsonData.relationship[i].url;
		relationshipArray[i] = new Relationship(id, subject, predicate, object, url);
	}
}


// CLASS :
function Node(id, cn, n, nId, u){
	// 【 MEMBER DATA 】:
	// Data:
	var ID;
	var className;
	var name;
	var url;

	// ellipse data:
	var index;
	var x;
	var y;
	var r;
	var alpha;

	// 【 MEMBER FUNCTION 】:
	// function of setting Data
	var dataInit = function(id, cn, n, nId, u){
		ID = id;
		className = cn;
		name = n;
		url = u;

		index = nId;
		x = random(width/5, width*4/5);
		y = random(height/5, height*4/5);
		r = 40;
		alpha = 0;
	};

	var drawNode = function(){
		if(className === "dbo:Person"){
			fill('rgba(255, 123, 126, '+alpha+')');
			ellipse(x, y, r+25, r+25);
			fill('rgba(255, 123, 126, 1)');
			image(personIcon, 0, 0, 500, 500, x-r/2, y-r/2, r, r);
		}
		else if(className === "dbo:Place"){
			fill('rgba(45, 196, 227, '+alpha+')');
			ellipse(x, y, r+25, r+25);
			fill('rgba(45, 196, 227, 1)');
			image(locationIcon, 0, 0, 500, 500, x-r/2, y-r/2, r, r);
		}
		noStroke();
//		ellipse(x, y, r, r);
		text(ID+" : "+name, x, y+r+5);
	};
	var detector = function(){
		if(dist(mouseX, mouseY, x, y) < r){
			return true;
		}
		else{
			return false;
		}
	};

	this.update = function(){
		drawNode();
	};
	this.clicked = function(){
		if(detector() === true){
			window.open(url);
		}
	};
	this.moved = function(){
		if(detector() === true){
			alpha = 0.5;
		}
		else{
			alpha = 0;
		}
	};

	this.getID = function(){
		return ID;
	};
	this.getClassName = function(){
		return className;
	};
	this.getName = function(){
		return name;
	};
	this.getX = function(){
		return x;
	};
	this.getY = function(){
		return y;
	};
	this.getR = function(){
		return r;
	};
	this.getDetectionResult = function(){
		return detector();
	};
	this.setX = function(newX){
		x = newX;
	};
	this.setY = function(newY){
		y = newY;
	};

	// 【 CONSTRUCTOR MAIN PLACE】:
	// set Data in constructor:
	dataInit(id, cn, n, nId, u);
}

function Relationship(id, s, p, o, u) {
	// 【 MEMBER DATA 】:
	// Data:
	var ID;
	var subjectID;
	var predicate;
	var objectID;
	var url;

	// Line:
	var sX;
	var sY;
	var oX;
	var oY;
	var r;
	// 【 MEMBER FUNCTION 】:
	var dataInit = function(id, s, p, o, u){
		ID = id;
		predicate = p;
		url = u;
		r = 60;
		var count = 0;
		for(var i = 0; i < nodeArray.length; i++){
			if(nodeArray[i].getID() === s){
				subjectID = i;
				count++;
			}
			else if(nodeArray[i].getID() === o){
				objectID = i;
				count++;
			}

			if(count === 2){
				break;
			}
		}

		sX = nodeArray[subjectID].getX();
		sY = nodeArray[subjectID].getY();
		oX = nodeArray[objectID].getX();
		oY = nodeArray[objectID].getY();
	};

	var detector = function(){
		var textX = ((sX+oX)/2)-50;
		var textY = (sY+oY)/2-30;
		if(dist(mouseX, mouseY, textX, textY) < r){
			return true;
		}
		else{
			return false;
		}
	};
	var drawTriangle = function(){
		var v0 = createVector(oX, oY);
		var v1 = createVector(oX, oY);
		var a1 = createVector(10, -10);
		var v2 = createVector(oX, oY);
		var a2 = createVector(10, 10);
		v1.add(a1);
		v2.add(a2);

		noStroke();
		triangle(oX, oY, v1.x, v1.y, v2.x, v2.y);fill('rgba(255, 199, 99, 1)');
	};

	this.update = function(){
//		drawTriangle();

		stroke('rgba(133, 121, 99, 1)');
		strokeWeight(2.5);
		line(sX, sY, oX, oY);

		fill('rgba(255, 199, 99, 1)');
		strokeWeight(0);
		text(predicate, ((sX+oX)/2)-50, (sY+oY)/2-30);
	};
	this.clicked = function(){
		if(detector() === true){
			window.open(url);
		}
	};

	this.getSubjectID = function(){
		return subjectID;
	};
	this.getObjectID = function(){
		return objectID;
	};
	this.setSX = function(x){
		sX = x;
	};
	this.setSY = function(y){
		sY = y;
	};
	this.setOX = function(x){
		oX = x;
	};
	this.setOY = function(y){
		oY = y;
	};

	// 【 CONSTRUCTOR MAIN PLACE 】:
	dataInit(id, s, p, o, u);
}


// P5 EVENTS :
function mousePressed(){
	for(var i = 0; i < nodeArray.length; i++){
		if(nodeArray[i].getDetectionResult() === true){
			focusIndex = i;
			break;
		}
	}

	if(focusIndex === -1){
		pressX = mouseX;
		pressY = mouseY;
	}
}

function mouseDragged(){
	if(focusIndex !== -1){
		nodeArray[ focusIndex ].setX(mouseX);
		nodeArray[ focusIndex ].setY(mouseY);
		var count = 0;
		for(var i = 0; i < relationshipArray.length; i++){
			if(relationshipArray[i].getSubjectID() === focusIndex){
				relationshipArray[i].setSX(mouseX);
				relationshipArray[i].setSY(mouseY);
				count++;
			}
			else if(relationshipArray[i].getObjectID() === focusIndex){
				relationshipArray[i].setOX(mouseX);
				relationshipArray[i].setOY(mouseY);
				count++;
			}
			if(count === 2){
				break;
			}
		}
	}
	else{
		var moveX = mouseX-pressX;
		var moveY = mouseY-pressY;
		for(var i = 0; i < nodeArray.length; i++){
			var newX = nodeArray[i].getX()+moveX;
			var newY = nodeArray[i].getY()+moveY;
			nodeMoving(i, newX, newY);
			relationshipMoving(i, newX, newY);
		}
		pressX = mouseX;
		pressY = mouseY;
	}
}

function mouseReleased(){
	focusIndex = -1;
}

function mouseClicked(){
	if (mouseButton === CENTER){
		for(var i = 0; i < nodeArray.length; i++){
			nodeArray[i].clicked();
		}

		for(var i = 0; i < relationshipArray.length; i++){
			relationshipArray[i].clicked();
		}
	}
}

function mouseMoved(){
	for(var i = 0; i < nodeArray.length; i++){
		nodeArray[i].moved();
	}
}


function nodeMoving(nodeIndex, x, y){
	nodeArray[ nodeIndex ].setX(x);
	nodeArray[ nodeIndex ].setY(y);
}

function relationshipMoving(nodeIndex, x, y){
	var count = 0;
	for(var i = 0; i < relationshipArray.length; i++){
		if(relationshipArray[i].getSubjectID() === nodeIndex){
			relationshipArray[i].setSX(x);
			relationshipArray[i].setSY(y);
			count++;
		}
		else if(relationshipArray[i].getObjectID() === nodeIndex){
			relationshipArray[i].setOX(x);
			relationshipArray[i].setOY(y);
			count++;
		}
		if(count === 2){
			break;
		}
	}
}