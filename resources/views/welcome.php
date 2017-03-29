<html>
<head>
    <title>Bla</title>
</head>
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.3.0/css/bulma.css">
<body>
<div id="page-menu" class="container">
      <menuitens>
        <itemlist name="Dash">
            <item>
                
            </item> 
        </itemlist>    
      </menuitens>

</div>
    




<script src="https://unpkg.com/vue@2.1.8/dist/vue.js"></script>

<script>

Vue.component('menuitens', {
    template:`
            <aside class="menu">
                <ul v-for="itemlist in menuitens"></ul>
            </aside>
    `,
    mounted(){
        this.menuitens = this.$children;
    },

    data() {
        return { menuitens: [] };
    },
});

Vue.component('itemlist', {
    template:`
            <li><a :class="{ 'is-active': this.isActive }">{ this.name }</a></li>
    `,
    props: {
        name: {required: true}
    }
});

new Vue({
    el: '#page-menu'
});

</script>
</body>
</html>

