const checkPassword = (values) => {
  if (values.password !== values.password_confirmation) {
    // dialog('passwords.passwords_not_match', false);
    console.log('passwords.passwords_not_match');

    return false;
  }

  return true;
};

export default checkPassword;
