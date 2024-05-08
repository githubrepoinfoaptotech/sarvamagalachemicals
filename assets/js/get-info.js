Notiflix.Notify.init({
  width: "300px",
  position: "right-top",
  closeButton: true,
  fontAwesomeIconStyle: 'basic',
  fontAwesomeIconSize: '25px',
  success: {
    background: "#7edf4a",
    textColor: "#fff",
    childClassName: "notiflix-notify-success",
    notiflixIconColor: "rgb(255 255 255)",
    fontAwesomeClassName: "fas fa-circle-check",
    fontAwesomeIconColor: "rgb(255 255 255)",
    backOverlayColor: "rgba(50,198,130,0.2)",
  },
  failure: {
    background: "#e53430",
    textColor: "#fff",
    childClassName: "notiflix-notify-failure",
    notiflixIconColor: "rgb(255 255 255)",
    fontAwesomeClassName: "fa-solid fa-circle-xmark",
    fontAwesomeIconColor: "rgb(255 255 255)",
    backOverlayColor: "rgba(255,85,73,0.2)",
  },
});


document
  .getElementById("contactForm")
  .addEventListener("submit", function (event) {
    event.preventDefault();

    var formData = {
      name: document.getElementById("name").value,
      email: document.getElementById("email").value,
      subject: document.getElementById("subject").value,
      message: document.getElementById("message").value,
    };

    var apiUrl = "https://sarvamangalachemicals.com/site/api/send_mail";
    Notiflix.Loading.hourglass('Sending...');
    var options = {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify(formData),
    };

    fetch(apiUrl, options)
      .then((response) => {
        Notiflix.Loading.remove();
        if (!response.ok) {
          throw new Error("Network response was not ok");
        }
        return response.json();
      })
      .then((data) => {
        if (data.status === true) {
          Notiflix.Notify.success(`${data.message}`);
          document.getElementById("contactForm").reset();
        } else {
          Notiflix.Notify.failure(`${data.message}`);
        }
        console.log("API Response:", data);
      })
      .catch((error) => {
        Notiflix.Loading.remove();
        console.error("There was a problem with the fetch operation:", error);
      });
  });
