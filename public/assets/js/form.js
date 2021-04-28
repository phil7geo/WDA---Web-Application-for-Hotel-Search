document.addEventListener("DOMContentLoaded", () => {
    const $name = document.querySelector("#name");
    const $email = document.querySelector("#email");
    const $email_repeat = document.querySelector("#email_repeat");
    const $password = document.querySelector("#password");
    const $nameError = document.querySelector(".name-error");
    const $emailError = document.querySelector(".email-error");
    const $emailRepeatError = document.querySelector(".email_repeat-error");
    const $passwordError = document.querySelector(".password-error");
    const $submit = document.querySelector("button");
    let nameIsValid = false;
    let emailIsValid = false;
    let emailRepeatIsValid = false;
    let passwordIsValid = false;

    const getNameValidation = (name) => {
      if (
        name !== "" &&
        name.length > 3
      ) {
        nameIsValid = true;
      } else {
        nameIsValid = false;
      }
    };
  
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

    const getEmailRepeatValidation = (email_repeat) => {
      var email = document.getElementById("email").value;
      if (
        email_repeat == email
      ) {
        emailRepeatIsValid = true;
      } else {
        emailRepeatIsValid = false;
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
      if (emailIsValid && emailRepeatIsValid && passwordIsValid && nameIsValid) {
        $submit.disabled = false;
      } else {
        $submit.disabled = true;
      }
    };

  
    $name.addEventListener("input", (e) => {
      getNameValidation(e.target.value);
  
      if (!nameIsValid) {
        $name.classList.add("is-invalid");
        $nameError.classList.remove("d-none");
      } else {
        $name.classList.remove("is-invalid");
        $nameError.classList.add("d-none");
      }
  
      checkSigninBtn();
    });

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

    $email_repeat.addEventListener("input", (e) => {
      getEmailRepeatValidation(e.target.value);
  
      if (!emailRepeatIsValid) {
        $email_repeat.classList.add("is-invalid");
        $emailRepeatError.classList.remove("d-none");
      } else {
        $email_repeat.classList.remove("is-invalid");
        $emailRepeatError.classList.add("d-none");
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
  
    $nameError.classList.add("d-none");
    $emailError.classList.add("d-none");
    $emailRepeatError.classList.add("d-none");
    $passwordError.classList.add("d-none");
  });