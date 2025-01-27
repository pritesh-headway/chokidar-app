<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Contact Us Submission</title>
</head>
<body>
    <h2>New Contact Us Submission</h2>
    <p><strong>Society Name:</strong> {{ $contactUs->society_name }}</p>
    <p><strong>Country:</strong> {{ $contactUs->country }}</p>
    <p><strong>City:</strong> {{ $contactUs->city }}</p>
    <p><strong>Full Name:</strong> {{ $contactUs->full_name }}</p>
    <p><strong>Email:</strong> {{ $contactUs->email }}</p>
    <p><strong>Phone:</strong> {{ $contactUs->phone }}</p>
    <p><strong>Comments:</strong></p>
    <p>{{ $contactUs->comments }}</p>
</body>
</html>
