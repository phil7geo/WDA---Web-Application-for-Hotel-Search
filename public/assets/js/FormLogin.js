document.addEventListener("DOMContentLoaded", () => {
    const $email = document.querySelector("#email");
    const $password = document.querySelector("#password");
    const $emailError = document.querySelector(".email-error");
    const $passwordError = document.querySelector(".password-error");
    const $submit = document.querySelector("button");
    let emailIsValid = false;
    let passwordIsValid = false;
  
    const getEmailValidation = (email) => {
      if (
        email !== "" &&
        /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(email) 
      ) {
        emailIsValid = true;
      } else {
        emailIsValid = false;
      }
    };
  
    const getpasswordValidation = (password) => {
      if (email !== "" && password.length > 4) {
        passwordIsValid = true;
      } else {
        passwordIsValid = false;
      }
    };
  
    const checkSigninBtn = () => {
      if (emailIsValid && passwordIsValid) {
        $submit.disabled = false;
      } else {
        $submit.disabled = true;
      }
    };

    $email.addEventListener("input", (e) => {
      getEmailValidation(e.target.value);
  
      if (!emailIsValid) {
        $email.classList.add("is-invalid");
        $emailError.classList.remove("d-none");
      } else {
        $email.classList.remove("is-invalid");
        $emailError.classList.add("d-none");
      }
      checkSigninBtn();
    });
  
    $password.addEventListener("input", (e) => {
      getpasswordValidation(e.target.value);
  
      if (!passwordIsValid) {
        $password.classList.add("is-invalid");
        $passwordError.classList.remove("d-none");
      } else {
        $password.classList.remove("is-invalid");
        $passwordError.classList.add("d-none");
      }
  
      checkSigninBtn();
    });
  
    $emailError.classList.add("d-none");
    $passwordError.classList.add("d-none");
  });