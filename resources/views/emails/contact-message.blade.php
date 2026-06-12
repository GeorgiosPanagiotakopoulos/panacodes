<h2>New contact form message</h2>

<p><strong>Name:</strong> {{ $data['name'] }}</p>
<p><strong>Email:</strong> {{ $data['email'] }}</p>
<p><strong>Phone:</strong> {{ $data['phone_number'] ?? 'Not provided' }}</p>

<p><strong>Message:</strong></p>
<p>{{ $data['message'] }}</p>