<template>
    <div class="aniVSideBarContainer h100 box0">
        <div class="row h100 box0">
            <div class="col-lg-offset-0 col-lg-12 col-md-offset-0 col-md-12
	                        col-sm-offset-0 col-sm-12 col-xs-offset-0 col-xs-12 h100 box0">
                <component :is="prop.block0.grid" :prop="prop.block0.prop" class="block0 h100"></component>
            </div>
        </div>

        <div class="row h100 box0">
            <div class="col-lg-offset-0 col-lg-3 col-md-offset-0 col-md-3
	                        col-sm-offset-0 col-sm-10 col-xs-offset-0 col-xs-12 h100 box0">
                <div class="row h100 box0">
                    <div class="col-lg-offset-0 col-lg-12 col-md-offset-0 col-md-12
			                        col-sm-offset-0 col-sm-12 col-xs-offset-0 col-xs-12 h100 box0">
                        <component :is="prop.block1.grid" :prop="prop.block1.prop" class="block1 h100" :style="transform: 'translate('+block1Status+'%, 0)';"></component>
                    </div>
                </div>

                <div class="row h100 box0">
                    <div class="functionalBar h100 box0">
                        <component :is="prop.block2.grid" :prop="prop.block2.prop" class="block2 h100"></component>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>


<script>
    export default{
    	props: ['prop'],
        data(){
    		return{
    			block1Status: '-100',
                lastClick: 'null',
            };
    	},
        computed:{},
        watch:{},
        methods:{
            block1Animate: function(btnId){
            	if(this.block1Status === '-100'){
					this.block1Status = '0';
            		this.lastClick = btnId;
                }
                else{
                    if(this.lastClick === btnId){
						this.block1Status = '-100';
						this.lastClick = 'null';
                    }
                    else{
                    	this.lastClick = btnId;
                    }
                }
            }
        },
        mounted(){}
    }
</script>


<style>
    .h100{
        height: 100%;
    }

    .box0{
        padding: 0;
        border: 0;
        margin: 0;
    }

    .aniVSideBarContainer,
    .aniVSideBarContainer > .row{
        width: 100%;
    }

    .aniVSideBarContainer > .row:nth-child(1){
        z-index: 0;
        position: absolute;
    }
    .aniVSideBarContainer > .row:nth-child(2){
        z-index: 1;
    }

    .aniVSideBarContainer > .row:nth-child(2) > div > .row{
        position: absolute;
    }

    .aniVSideBarContainer > .row:nth-child(2) > div > .row:nth-child(1){
        width: 100%;
    }

    .aniVSideBarContainer > .row:nth-child(2) > div > .row:nth-child(2){
        z-index: 2;
    }

    .aniVSideBarContainer > .row > div > .block0{
        background-color: #9d9d9d;

    }
    .aniVSideBarContainer > .row:nth-child(2) > div > .row:nth-child(1) > div > .block1{
        background-color: #ff9d9d;
        transform: translate(-100%, 0);
        transition: 0.7s;
    }

    .aniVSideBarContainer > .row:nth-child(2) > div > .row:nth-child(2) > div > .block2{
        background-color: #9d9dff;
    }
</style>