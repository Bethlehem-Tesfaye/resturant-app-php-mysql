const billingRadios = document.querySelectorAll('input[name="billing"]');
const hideableFields = document.querySelectorAll(".hideable");

billingRadios.forEach((radio) => {
  radio.addEventListener("change", () => {
    if (radio.value === "cash" && radio.checked) {
      hideableFields.forEach((field) => field.classList.add("hidden"));
    } else {
      hideableFields.forEach((field) => field.classList.remove("hidden"));
    }
  });
});

// Trigger change on load in case 'annual' is selected
document
  .querySelector('input[name="billing"]:checked')
  .dispatchEvent(new Event("change"));
