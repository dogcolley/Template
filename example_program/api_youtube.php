<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="https://unpkg.com/vue"></script>
    <title>API 유투브 테스트</title>
</head>
<body>
    
    <div id="app">
        {{message}}

    </div>

    <script>
        var app = new Vue({
		  el: '#app',
		  data: {
			message: 'HI YOUTUBE AND VUE JS'
		  },
		  methods: {
			reverseMessage: function () {
			  this.message = this.message.split('').reverse().join('')
			}
		  }
		});
    </script>
</body>
</html>