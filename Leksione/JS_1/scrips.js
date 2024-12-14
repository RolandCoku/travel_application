// var emri = window.prompt("Vendosni emrin");
// document.write("<h1>Pershendetje " + emri + "</h1>");

//
// function generateNumbers() {
//     return Math.floor(1 + Math.random() * 6)
// }
//
// var number;
// document.write(
//     "<table style='border: 1px solid black; text-align: center; width: 30%'> " +
//             "<thead>" +
//                 "<tr style='border: 1px solid black; text-align: center'>" +
//                     "<th style='border: 1px solid black; text-align: center'>Col1</th>" +
//                     "<th style='border: 1px solid black; text-align: center'>Number</th>" +
//                 "</tr>" +
//             "</thead>" +
//             "<tbody>");
// for (var i = 0; i <= 30; i++) {
//     number = generateNumbers();
//     // document.write("\n Numri: " + number + " <br>");
//
//     document.write(
//         "<tr style='border: 1px solid black; text-align: center'>" +
//             "<td style='border: 1px solid black; text-align: center'>Number</td>" +
//             "<td style='border: 1px solid black; text-align: center'>" + number + "</td>" +
//         "</tr>"
//     );
// }
// document.write("</tbody>");
// document.write("</table>");

function saveData (){
    window.alert("Butoni u kliku");

    var emri = document.getElementById("emri").value;
    var mbiemri = document.getElementById("mbiemri").value;
    var email = document.getElementById("email");

    console.log(emri);
    console.log(mbiemri);
    console.log(email);
}

