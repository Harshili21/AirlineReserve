document.addEventListener("DOMContentLoaded", function() {
    let flights = [
        { id: 1, airline: "Air India", destination: "Mumbai", date: "2025-05-10", price: "$250" },
        { id: 2, airline: "IndiGo", destination: "Delhi", date: "2025-05-12", price: "$200" }
    ];
    
    let table = document.getElementById("flightTable");

    flights.forEach(flight => {
        let row = table.insertRow();
        row.innerHTML = `<td>${flight.airline}</td><td>${flight.destination}</td><td>${flight.date}</td><td>${flight.price}</td>
                         <td><button onclick="bookFlight(${flight.id})">Book</button></td>`;
    });
});

function bookFlight(id) {
    alert("Flight " + id + " booked!");
}