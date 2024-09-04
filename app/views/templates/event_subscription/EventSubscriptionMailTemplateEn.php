<html>

<head>
  <meta http-equiv="Content-Type" content="text/html" charset="utf-8" />
</head>

<body style="background-color: #f8f9fa;">
  <div style="max-width: 600px; margin: 0 auto; background-color: #ffffff; padding: 20px;">
    <div style="text-align: center;">
      <div>
        <h1>{{event_name}}</h1>
        <h3><span>{{start_date}}</span> - <span>{{end_date}}</span></h3>
      </div>
      <hr>
      <h2 class="h3 mb-2">Dear {{name}}</h2>
      <h5 class="text-teal-700">Your registration for the event was successful!</h5>
      <div class="space-y-3">
        <p class="text-gray-700"></p>
        <h3 class="text-gray-700">
          <b>Thank you for completing the registration form.</b>
        </h3>

        <div style="border: 1px solid">
          <h3>Your registration details are as follows:</h3>
          <p><b>Name</b>: {{name}}</p>
          <p><b>Email</b>: {{email}}</p>
          <p><b>Address</b>: {{address}}</p>
          <p><b>Phone Number</b>: {{mobile}}</p>
          <p><b>Selected Dates</b>: {{dates}}</p>
          <p><b>Selected Tasks</b>: {{tasks}}</p>
        </div>

        <p>
          <b>Please verify that you have entered your email address correctly, as further information will be sent there!</b>
        </p>
        <p>You can track or cancel your event registration from your profile.</p>
        <p>If you registered without a profile, you can cancel by following this link: <a href="{{url}}/subscription/delete/{{id}}">{{url}}/subscription/delete/{{id}}</a></p>
        <br>
        <p>We look forward to meeting you and working together!</p>
        <p><b>VAP Team</b></p>
      </div>
    </div>
</body>

</html>
