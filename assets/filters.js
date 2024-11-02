window.onload = ( ) => {
  const FilterForm = document.querySelector("#filters");

  document.querySelectorAll("#filters input").forEach(input => {
    input.addEventListener("change", (e) => {
      console.log("input changed");
    });
  });
}