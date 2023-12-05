function openPopup() {
    document.getElementById("popup").style.display = "flex";
    setTimeout(closePopup, 3000);
}

function closePopup() {
    document.getElementById("popup").style.display = "none";
}