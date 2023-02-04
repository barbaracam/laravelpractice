<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Hello, this is a blade template for Homepage</h1>
    Code dynamic is 2 + 2 = {{2 + 2}}<br>
    {{$name}}
    {{$catName}}
    <ul>
        @foreach ($allAnimals as $animal)
            <li>{{$animal}}</li>
        @endforeach
    </ul>
    <a href="/about">Go to the About Page</a>
</body>
</html>