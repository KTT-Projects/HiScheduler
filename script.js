$(function () {
  let login = false, register = false
  function toggleLogin(times) {
    $('.login_btn, login_btn ~ div').toggleClass('open')
    if (login == false) {
      login = true
    } else if (login == true) {
      login = false
    }
    if (times == undefined && register == true) {
      toggleRegister(1)
    }
  }
  function toggleRegister(times) {
    $('.register_btn').toggleClass('open')
    if (register == false) {
      register = true
    } else if (register == true) {
      register = false
    }
    if (times == undefined && login == true) {
      toggleLogin(1)
    }
  }

  $('.close_error').click(function () {
    $('.error, .error_container, close_error').addClass('error_container_active')
  })
  $('.login_btn').click(function () {
    toggleLogin()
  })
  $('.register_btn').click(function () {
    toggleRegister()
  })
})