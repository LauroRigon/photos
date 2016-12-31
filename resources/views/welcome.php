<html>
<head>
    <title>Bla</title>
</head>

<body>
    <div id="root">

        <li v-for="task in tasks" v-if="task.completed" v-text="task.description"></li>

        <h2>Incomplete</h2>
        <li v-for="task in incompleteTasks" v-text="task.description"></li>
    </div>



    <script src="https://unpkg.com/vue@2.1.8/dist/vue.js"></script>

<script>

    var app = new Vue({
        el: '#root',
        data:{
            tasks: [
                {description: "Something", completed: true},
                {description: "play lol", completed: false},
                {description: "play witcher", completed: true}
            ]
        },
        computed:{
            incompleteTasks(){
                return this.tasks.filter(task => !  task.completed);
            }
        },
        methods:{

        }
    });


</script>
</body>
</html>

