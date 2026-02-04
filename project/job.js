function validateApplyForm() {
    const cover = document.getElementById("cover").value;
    if (cover.trim() === "") {
        alert("Cover letter cannot be empty");
        return false;
    }
    return true;
}
