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
		<!-- FOR Neo4J -->
		<script src="../../js/neo4j/lib/browser/neo4j-web.js"></script>
		<script type="text/javascript">

		var driver;
		var session;
		var authToken;
		var resultList = [];

		function neo4jConnection(){
				var account = "neo4j";
				var password = "123";
				authToken = neo4j.v1.auth.basic(account, password);
				driver = neo4j.v1.driver("bolt://localhost", authToken, {
						encrypted:false
				});
				session = driver.session();
		}


		function message(mess){
				console.log(mess);
		}

		function main(){

			var cypher = "MATCH rdf=(s:人)-[p]-(o:車牌號碼) RETURN rdf LIMIT 15";
			// connect to the Neo4J
			neo4jConnection();
			session
				.run(cypher)
				.subscribe({
						// cypher query result preprocessing
						onNext: function(record) {
						},
						// the main work after preprocessing finished
						onCompleted: function(metadata) {
								session.close();
								driver.close();

								visuallization();
						}
				});
		}





		</script>
    </head>
    <body onload="main()">

    </body>
</html>



