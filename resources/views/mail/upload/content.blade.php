<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>New Upload</title>
</head>

<style>
    #container {
        border: 1px solid #ccc;
        padding: 10px;
        margin: 10px;
        display: flex;
        flex-direction: column;
        gap: 10px;
    }
</style>

<body>
    <div id="container">
        <h1>New Upload</h1>
        <p>Project: {{ $project->name }}</p>
        <p>By: {{ $user->name }}</p>
        <p>Name: {{ $name }}</p>
        <p>Description:</p>
        <p>{{ $description }}</p>
    </div>
</body>

</html>
