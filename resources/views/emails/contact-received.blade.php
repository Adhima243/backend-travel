<!doctype html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Pesan Kontak Baru</title>
  </head>
  <body>
    <h2>Pesan Kontak Baru dari {{ $contact->name }}</h2>
    <p><strong>Email:</strong> {{ $contact->email }}</p>
    @if($contact->phone)
      <p><strong>Phone:</strong> {{ $contact->phone }}</p>
    @endif
    <hr />
    <p>{{ nl2br(e($contact->message)) }}</p>
    <p>--</p>
    <p>This message was sent from the Travelin contact form.</p>
  </body>
  </html>
