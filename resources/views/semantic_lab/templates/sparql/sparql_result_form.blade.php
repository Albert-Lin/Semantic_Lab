<?php
/**
 * Created by PhpStorm.
 * User: AlbertLin
 * Date: 2017/2/13
 * Time: 上午 10:55
 */
?>
<style>
    #sparqlResultBlock{
        display: none;
    }
    #sparqlResult{
        margin-bottom: 80px;
    }
    #sparqlResult>.boxHeader{
        background-color: #f0ad4e;
        margin-left: 0;
        margin-right: 0;
    }
    #sparqlResult>.boxHeader>.headerTitle{
        float: left;
    }

    #sparqlResult>.boxHeader>.headerCloseBtn{
        float: right;
        background-color: #f0ad4e;
    }
    #sparqlResultBody{
        overflow-x: hidden;
        overflow-y: auto;
        font-size: 14px;
        word-wrap: break-word;
    }
</style>
<div id="sparqlResultBlock" class="row h100">
    <div id="sparqlResult" class="col-md-offset-1 col-md-10 layoutBox h100">
        <div class="boxHeader row">
            <div class="headerTitle">Search Result:</div>
            <button class="headerCloseBtn btn btn-sm glyphicon glyphicon-remove"></button>
        </div>
        <div id="sparqlResultBody" class="boxBody h100" ></div>
    </div>
</div>
<script>

    $(function(){

    	$('#sparqlResult .headerCloseBtn').on('click', function(){
			$('#sparqlResultBlock').css('display', 'none');
        });

		$('body').on('click', 'td', function(){
			console.log($(this).html());
		});
    });
</script>
