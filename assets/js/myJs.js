let alert_invlid = document.querySelectorAll("#alert-invlid");


// for (let i = 0; i < alert_invlid.length; i++) {


//     setTimeout(() => {
//         alert_invlid[i].remove();
//     }, 1600);

// }

let image = document.getElementById("image");
let image_name = document.getElementById('image_name');

image.addEventListener("change", function () {
    image_name.innerHTML = image.files[0].name;
})