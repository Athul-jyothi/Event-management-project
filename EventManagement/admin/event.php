<?php
include 'connection.php';
$stmt = $conn->prepare("SELECT * FROM `events`");
$stmt->execute();
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
echo json_encode($rows);
?>
<html>
  <head>
    <style>
      table {
        width: 100%;
        border-collapse: collapse;
      }
      th, td {
        border: 1px solid black;
        padding: 8px;
        text-align: center;
      }
      th {
        background-color: lightgray;
      }
      .event {
        background-color: yellow;
      }
    </style>
    <script>
      function showEvents(date) {
        // Filter events based on the selected date
        var events = [
          {"_eventId":"46","_eventName":"Onam2ka","_eventDesc":"qw","_eventBatch":"3","_eventdate":"2023-02-05","_isCreated":"8","_isActive":"0"},
];
var filteredEvents = events.filter(function(event) {
return event._eventdate === date;
});    // Populate the table with the filtered events
    var table = document.getElementById("event-table");
    while (table.rows.length > 1) {
      table.deleteRow(1);
    }
    filteredEvents.forEach(function(event) {
      var row = table.insertRow();
      var idCell = row.insertCell();
      idCell.innerHTML = event._eventId;
      var nameCell = row.insertCell();
      nameCell.innerHTML = event._eventName;
      var descCell = row.insertCell();
      descCell.innerHTML = event._eventDesc;
      var batchCell = row.insertCell();
      batchCell.innerHTML = event._eventBatch;
    });
  }
</script>
</head>
  <body>
    <table id="calendar">
      <tr>
        <th>Sun</th>
        <th>Mon</th>
        <th>Tue</th>
        <th>Wed</th>
        <th>Thu</th>
        <th>Fri</th>
        <th>Sat</th>
      </tr>
      <tr>
        <!-- First row of the calendar -->
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
    </table>
    <br />
    <table id="event-table">
      <tr>
        <th>Event ID</th>
        <th>Event Name</th>
        <th>Event Description</th>
        <th>Event Batch</th>
      </tr>
    </table>
  </body>
</html>