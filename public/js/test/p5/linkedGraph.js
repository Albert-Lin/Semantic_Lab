/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


// GLOBAL VARIABLE:
//==============================================
var GLOBAL = {
	'jsonData' : {},
	'nodeArray' : [],
	'relationshipArray' : [],
	'focusIndex' : -1,
	'personIcon' : {},
	'locationIcon' : {},
	'pressX' : -1,
	'pressY' : -1
};


// P5 DEFINED FUNCTION :
//==============================================
function preload(){
	var jsonURL = 'http://semantic_lab/js/test/p5/json/node.json';
	GLOBAL.jsonData = loadJSON(jsonURL);
	var personURL = 'http://semantic_lab/image/person.png';
	GLOBAL.personIcon = loadImage(personURL);
	var locationURL = 'http://semantic_lab/image/location.png';
	GLOBAL.locationIcon = loadImage(locationURL);
}

function setup(){
	// P5:
	createCanvas(windowWidth, windowHeight);
	frameRate(60);

	// Data IIFE:
	(function (){
		// create nodes:
		for(var i = 0; i < GLOBAL.jsonData.node.length; i++){
			var id = GLOBAL.jsonData.node[i].id;
			var className = GLOBAL.jsonData.node[i].class;
			var name = GLOBAL.jsonData.node[i].name;
			var url = GLOBAL.jsonData.node[i].url;
			GLOBAL.nodeArray.push(new Node(id, className, name, i, url));
		}

		// create relationship:
		for(var i =  0; i < GLOBAL.jsonData.relationship.length; i++){
			var id = GLOBAL.jsonData.relationship[i].id;
			var subject = GLOBAL.jsonData.relationship[i].subject;
			var predicate = GLOBAL.jsonData.relationship[i].predicate;
			var object = GLOBAL.jsonData.relationship[i].object;
			var url = GLOBAL.jsonData.relationship[i].url;
			GLOBAL.relationshipArray.push(new Relationship(id, subject, predicate, object, url));
		}
	})();
}

function draw(){
	background(47, 53, 62);
	for(var i = 0; i < GLOBAL.relationshipArray.length; i++){
		GLOBAL.relationshipArray[i].update();
	}

	for(var i = 0; i < GLOBAL.nodeArray.length; i++){
		GLOBAL.nodeArray[i].update();
	}
}


// GLOBAL FUNCTION :
//==============================================
function numberVali(num){
	if( typeof(num) === "number" && window.isNaN(num) === false ){
		return true;
	}
	else{
		return false;
	}
}

function nodeMoving(nodeIndex, x, y){
	GLOBAL.nodeArray[ nodeIndex ].setX(x);
	GLOBAL.nodeArray[ nodeIndex ].setY(y);
}

function relationshipMoving(nodeIndex, x, y){
	var count = 0;
	for(var i = 0; i < GLOBAL.relationshipArray.length; i++){
		if(GLOBAL.relationshipArray[i].getSubjectID() === nodeIndex){
			GLOBAL.relationshipArray[i].setSX(x);
			GLOBAL.relationshipArray[i].setSY(y);
			count++;
		}
		else if(GLOBAL.relationshipArray[i].getObjectID() === nodeIndex){
			GLOBAL.relationshipArray[i].setOX(x);
			GLOBAL.relationshipArray[i].setOY(y);
			count++;
		}
		if(count === 2){
			break;
		}
	}
}


// P5 EVENTS FUNCTION :
//==============================================
function mousePressed(){
	for(var i = 0; i < GLOBAL.nodeArray.length; i++){
		if(GLOBAL.nodeArray[i].getDetectionResult() === true){
			GLOBAL.focusIndex = i;
			break;
		}
	}

	if(GLOBAL.focusIndex === -1){
		GLOBAL.pressX = mouseX;
		GLOBAL.pressY = mouseY;
	}
}

function mouseDragged(){
	if(GLOBAL.focusIndex !== -1){
		nodeMoving(GLOBAL.focusIndex, mouseX, mouseY);
		relationshipMoving(GLOBAL.focusIndex, mouseX, mouseY);
	}
	else{
		var moveX = mouseX-GLOBAL.pressX;
		var moveY = mouseY-GLOBAL.pressY;
		for(var i = 0; i < GLOBAL.nodeArray.length; i++){
			var newX = GLOBAL.nodeArray[i].getX()+moveX;
			var newY = GLOBAL.nodeArray[i].getY()+moveY;
			nodeMoving(i, newX, newY);
			relationshipMoving(i, newX, newY);
		}
		GLOBAL.pressX = mouseX;
		GLOBAL.pressY = mouseY;
	}
}

function mouseReleased(){
	GLOBAL.focusIndex = -1;
}

function mouseClicked(){
	if (mouseButton === CENTER){
		for(var i = 0; i < GLOBAL.nodeArray.length; i++){
			GLOBAL.nodeArray[i].clicked();
		}

		for(var i = 0; i < GLOBAL.relationshipArray.length; i++){
			GLOBAL.relationshipArray[i].clicked();
		}
	}
}

function mouseMoved(){
	for(var i = 0; i < GLOBAL.nodeArray.length; i++){
		GLOBAL.nodeArray[i].moved();
	}
}


// CLASS :
//==============================================
function Node(id, cn, n, nId, u){
	if(this instanceof Node){
		// [ private member data ] :
		// Data:
		var ID;
		var className;
		var name;
		var url;

		// Ellipse data:
		var index;
		var x;
		var y;
		var r;
		var alpha;

		// [ private member function ]
		var dataInit;
		var drawNode;
		var mouseFocusDetector;
		dataInit = function(id, cn, n, nId, u){
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
		drawNode = function(){
			if(className === "dbo:Person"){
				fill('rgba(255, 123, 126, '+alpha+')');
				ellipse(x, y, r+25, r+25);
				fill('rgba(255, 123, 126, 1)');
				image(GLOBAL.personIcon, 0, 0, 500, 500, x-r/2, y-r/2, r, r);
			}
			else if(className === "dbo:Place"){
				fill('rgba(45, 196, 227, '+alpha+')');
				ellipse(x, y, r+25, r+25);
				fill('rgba(45, 196, 227, 1)');
				image(GLOBAL.locationIcon, 0, 0, 500, 500, x-r/2, y-r/2, r, r);
			}
			noStroke();
			text(ID+" : "+name, x, y+r+5);
		};
		mouseFocusDetector = function(){
			if(dist(mouseX, mouseY, x, y) < r){
				return true;
			}
			else{
				return false;
			}
		};

		// [ public member function ]
		this.update = function(){
			drawNode();
		};
		this.clicked = function(){
			if(mouseFocusDetector() === true){
				window.open(url);
			}
		};
		this.moved = function(){
			if(mouseFocusDetector() === true){
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
			return mouseFocusDetector();
		};
		this.setX = function(newX){
			if( numberVali(newX) === true ){
				x = newX;
			}
		};
		this.setY = function(newY){
			if( numberVali(newY) === true ){
				y = newY;
			}
		};
		this.setR = function(newR){
			if( numberVali(newR) === true ){
				r = newR;
			}
		};

		// [ execute method ]
		dataInit(id, cn, n, nId, u);
	}
	else{
		console.log("function Node() could not used as simple function, \r\nplease add the sepecial keyword 'new'. ");
		return new Node(id, cn, n, nId, u);
	}
}

function Relationship(id, s, p, o, u) {
	if(this instanceof Relationship){
		// [ private member data]:
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

		// [ private member function ]
		var dataInit;
		var drawLine;
		var mouseFocusDetector;
		var drawTriangle;
		dataInit = function(id, s, p, o, u){
			var count = 0;
			ID = id;
			predicate = p;
			url = u;
			r = 60;
			for(var i = 0; i < GLOBAL.nodeArray.length; i++){
				if(GLOBAL.nodeArray[i].getID() === s){
					subjectID = i;
					count++;
				}
				else if(GLOBAL.nodeArray[i].getID() === o){
					objectID = i;
					count++;
				}

				if(count === 2){
					break;
				}
			}

			sX = GLOBAL.nodeArray[subjectID].getX();
			sY = GLOBAL.nodeArray[subjectID].getY();
			oX = GLOBAL.nodeArray[objectID].getX();
			oY = GLOBAL.nodeArray[objectID].getY();
		};

		drawLine = function(){
			stroke('rgba(133, 121, 99, 1)');
			strokeWeight(2.5);
			line(sX, sY, oX, oY);

			fill('rgba(255, 199, 99, 1)');
			strokeWeight(0);
			text(predicate, ((sX+oX)/2)-50, (sY+oY)/2-30);
		};

		mouseFocusDetector = function(){
			var textX = ((sX+oX)/2)-50;
			var textY = (sY+oY)/2-30;
			if(dist(mouseX, mouseY, textX, textY) < r){
				return true;
			}
			else{
				return false;
			}
		};

		drawTriangle = function(){
			var v1 = createVector(oX, oY);
			var a1 = createVector(10, -10);
			var v2 = createVector(oX, oY);
			var a2 = createVector(10, 10);
			v1.add(a1);
			v2.add(a2);

			noStroke();
			triangle(oX, oY, v1.x, v1.y, v2.x, v2.y);fill('rgba(255, 199, 99, 1)');
		};

		// [ public member function ]
		this.update = function(){
			drawLine();
		};
		this.clicked = function(){
			if(mouseFocusDetector() === true){
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
			if(numberVali(x) === true){
				sX = x;
			}
		};
		this.setSY = function(y){
			if(numberVali(y) === true){
				sY = y;
			}
		};
		this.setOX = function(x){
			if(numberVali(x) === true){
				oX = x;
			}
		};
		this.setOY = function(y){
			if(numberVali(y) === true){
				oY = y;
			}
		};

		// [ execute method ]
		dataInit(id, s, p, o, u);
	}
	else{
		console.log("function Relationship() could not used as simple function, \r\nplease add the sepecial keyword 'new'. ");
		return new Relationship(id, s, p, o, u);
	}
}

