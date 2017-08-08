<html>
<head>
  <title>Dan disco duck page</title>

</head>


<body>
  <h1>Dan duck page</h1>
    <h2>Fee free to search</h2>
{{ Form::open(['method' =>'get','route'=>'duck_search']) }}

{{ Form::text('query',$query) }}

{{ Form::submit('Search All Ducks') }}
{{ Form::close() }}



@if(isset($results))
<table>
  <tr>
    <th>Name</th>
    <th>Age</th>
    <th>Color</th>
    <th>Gender</th>
    <th>hometown</th>
    <th>Funky?</th>
    <th>About</th>
    <th>registered Date</th>
  </tr>
@foreach($results as $result)
<tr>
<td>{{ $result->name }}</td>
<td>{{ $result->age }}</td>
<td>{{ $result->color }}</td>
<td>{{ $result->gender }}</td>
<td>{{ $result->hometown }}</td>
<td>{{ $result->funkyDuck }}</td>
<td>{{ $result->about }}</td>
<td>{{ $result->registered }}</td>
</tr>
@endforeach
</table>
@endif
</body>
</html>
