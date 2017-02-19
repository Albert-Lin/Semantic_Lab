<?php
/**
 * Created by PhpStorm.
 * User: AlbertLin
 * Date: 2017/2/13
 * Time: 上午 10:55
 */
?>
<style>
    #sparqlResultBlock {
        display: none;
        padding-top: 25px;
    }

    #sparqlResultBody{
        max-height: calc(100% - 65px);
        overflow-x: hidden;
        overflow-y: auto;
        font-size: 16px;
        font-weight: bolder;
        word-wrap: break-word;
    }

    .lb2Title{
        background-color: #fb8c00;
        box-shadow: 0 0 15px 0 rgba(151, 99, 2, 0.6);
        color: #ffffff;
        font-weight: 800;
    }

    .lb2Title .headerCloseBtn{
        float: right;
        background-color: inherit;
    }
    .lb2Title .headerCloseBtn:active, .lb2Title .headerCloseBtn:focus{
        outline: none;
    }

</style>

<div id="sparqlResultBlock" class="row h100">
    <div class="col-md-12 h100">
        <div class="layoutBox2 row h100">
            <div class="col-md-offset-1 col-md-10 h100">
                <div class="lb2Title">
                    Search Result:
                    <button class="headerCloseBtn btn btn-sm glyphicon glyphicon-remove"></button>
                </div>
                <div class="lb2BodyBlock row h100">
                    <div id="sparqlResultBody" class="lb2Body col-md-12 h100"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>

    $(function(){

    	$('.lb2Title .headerCloseBtn').on('click', function(){
			$('#sparqlResultBlock').css('display', 'none');
        });

		$('body').on('click', 'td', function(){
			console.log($(this).html());
		});
    });
</script>
