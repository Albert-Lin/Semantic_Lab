<template>
    <div class="aniVSideBarContainer h100 box0">
        <div class="row h100 box0">
            <div class="col-lg-offset-0 col-lg-12 col-md-offset-0 col-md-12
	                        col-sm-offset-0 col-sm-12 col-xs-offset-0 col-xs-12 h100 box0">
                <component v-if="prop.main !== undefined" :is="prop.main.grid" :prop="prop.main.prop" class="main h100"
                           :style="'padding-left: '+functionBarWidth+'px;'"></component>
            </div>
        </div>

        <div class="row h100 box0">
            <div class="col-lg-offset-0 col-lg-3 col-md-offset-0 col-md-3
	                        col-sm-offset-0 col-sm-10 col-xs-offset-0 col-xs-12 h100 box0">
                <div class="row h100 box0">
                    <div class="col-lg-offset-0 col-lg-12 col-md-offset-0 col-md-12
			                        col-sm-offset-0 col-sm-12 col-xs-offset-0 col-xs-12 h100 box0">
                        <component v-if="prop.funContent !== undefined" :is="prop.funContent.grid" :prop="prop.funContent.prop" class="funContent h100"
                                   :style="'transform: translate('+block1Status+'%, 0); padding-left: '+functionBarWidth+'px;'"></component>
                    </div>
                </div>

                <div class="row h100 box0">
                    <div class="funBar h100 box0" :style="'width: '+functionBarWidth+'px;'" v-on:click="block1Animate('x')">
                        <component v-if="prop.funBar !== undefined" :is="prop.funBar.grid" :prop="prop.funBar.prop" class="funBar h100"></component>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>


<script>
    export default{
    	props: ['prop'],
	    components: {
    		gridSystem: require('../grids/gridSystem.vue')
    	},
        data(){
    		return{
    			block1Status: '-100',
                lastClick: 'null',
			    functionBarWidth: 70,
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

    .aniVSideBarContainer > .row > div > .main{
        background-color: #9d9d9d;

    }
    .aniVSideBarContainer > .row:nth-child(2) > div > .row:nth-child(1) > div > .funContent{
        background-color: #ff9d9d;
        /*transform: translate(-100%, 0);*/
        transition: 0.7s;
    }

    .aniVSideBarContainer > .row:nth-child(2) > div > .row:nth-child(2) > div > .funBar{
        background-color: #9d9dff;
    }
</style>