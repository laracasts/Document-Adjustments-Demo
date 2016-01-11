<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
</head>
<body>
    
    <h1>{{ $document->title }}</h1>
    
    <div>{{ $document->body }}</div>

    <hr>

    <ul>
        @foreach ($document->adjustments as $user)
        <li>{{ $user->email }} on {{ $user->pivot->updated_at->diffForHumans() }}</li>
        @endforeach
    </ul>

</body>
</html>

