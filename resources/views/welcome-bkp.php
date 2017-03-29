<html>
<head>
    <title>Bla</title>
</head>
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.3.0/css/bulma.css">
<body>
<div id="root" class="container">
     <tabs>
         <tab name="Home" :selected = "true">
             <h1>
                 This is our home
             </h1>
         </tab>
         <tab name="Our Work">
             <h1>
                This is Sparta!!!
             </h1>
         </tab>
         <tab name="Contact">
             <h1>
                Our Contact
             </h1>
         </tab>

         <tab name="Bye">
             <h1>
                Hue
             </h1>
         </tab>
     </tabs>

</div>
    




<script src="https://unpkg.com/vue@2.1.8/dist/vue.js"></script>

<script>
Vue.component('tabs', {
    template:`
        <div>
            <div class="tabs">
              <ul>
                <li v-for="tab in tabs" :class="{ 'is-active': tab.isActive }">
                    <a :href="tab.href" @click="selectTab(tab)">{{ tab.name }}</a>
                </li>
                
              </ul>
            </div>
            
            <div class="tabs-details">
                <slot></slot>
            </div>
        </div>
    `,
    mounted(){
        this.tabs = this.$children;
    },

    data() {
        return { tabs: [] };
    },

    methods: {
        selectTab(selectedTab){
            this.tabs.forEach(tab => {
                tab.isActive = (tab.name == selectedTab.name);
            });
        }
    }

    

});

Vue.component('tab', {
    template:`
        <div v-show="isActive"><slot></slot></div>
    `,

    props: {
        name:{ required: true },
        selected: { default: false }       
    },

    data(){
        return {
            isActive: false     
        }
        
    },

    mounted(){
        this.isActive = this.selected;
    },

    computed: {
        href(){
            return '#' + this.name.toLowerCase().replace(/ /g, '-');
        }
    }
});

new Vue({
    el: '#root'
});

</script>
</body>
</html>

