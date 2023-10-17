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
      <h2 class="h3 mb-2">Kedves {{name}}</h2>
      <h5 class="text-teal-700">Az eseményre való regisztráció sikeres volt!</h5>
      <div class="space-y-3">
        <p class="text-gray-700"></p>
        <h3 class="text-gray-700">
          <b>Köszönjük, hogy kitöltötte a jelentkezési lapot.</b>
        </h3>

        <div style="border: 1px solid">
          <h3>Regisztrációs adataid a következők voltak!</h3>
          <p><b>Név</b>: {{name}}</p>
          <p><b>E-mail cím</b>: {{email}}</p>
          <p><b>Lakhely</b>: {{address}}</p>
          <p><b>Telefonszám</b>: {{mobile}}</p>
          <p><b>Megjelölt dátumok</b>: {{dates}}</p>
          <p><b>Megjelölt feladatok</b>: {{tasks}}</p>
        </div>

        <p>
          <b> Kérjük ellenőrizd le, hogy az email címedet jól adtad meg, mert a további információt arra küldjük!</b>
        </p>
        <p>Az eseményre való jelentkezést a profilodból követheti vagy törörlheti!</p>
        <p>Ha a jelentkezés profil nélkül történt akkor a lemondás a következő linken lehetséges
          <a href="https://vap.max.hu/subscription/delete/{{id}}">https://vap.max.hu/subscription/delete/{{id}}</a>.
        </p>
        <br>
        <p>Örömmel várjuk a találkozást és a közös munkát!</p>
        <p><b>VAP Team</b></p>
      </div>
    </div>
</body>

</html>"