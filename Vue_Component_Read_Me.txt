01. make sure download Git for Windows
02. install the Git if nessesery
03. add both /cmd and /bin path into enviroment variables of Windows (both path and PATH)
04. restart the IDE, cmd, etc,.
04. open cmd and paste: "npm install --no-bin-links" for install the library in 
	* if you get "Maximum call stack size exceeded" error message from cmd, just re-run 04. again.
	* or !! check this page to fix it: https://github.com/npm/npm/issues/9953 (jhourlad commented on 16 Aug 2016 • edited)
05. install Gulp package: https://travismaynard.com/writing/getting-started-with-gulp
06. run "gulp webpack" for complie our gulpfile.js


//==[ VUE EXECUTE TIMING ]====
01. single file component:

    // component.vue:
    <template></template>

    <script>
        export default{
            props: ['props'],
            mounted(){ // ------- (1)
                console.log('component.mounted');
            }
        }
    </script>

    <style></style>


    // app.js:
    required(...);

    Vue.component('component', required(./{PATH}/component.vue));

    const container = new Vue({
        el: '#container'
        data: {
            info: [
                {
                    component: 'component',
                    prop: {
                        prop0: 'def'';
                    }
                }
            ]
        },
        mounted: function(){ // ------- (2)
            console.log('container.mounted');
            this.info[0].prop.prop0 = 'changed'
        }
    });