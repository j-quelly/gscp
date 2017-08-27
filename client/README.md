# GSCP Client
client side to GSCP API

## client version 0.4.2

### login component
- [x] button states
- [x] button border
- [x] button text shadow
- [x] glyph icons
- [x] pull out form styles for separate component/stylesheet
- [x] add form validation [8/26/2017]
- [x] add validation for email addresses [8/26/2017]
- [ ] interface with lumen API
- [ ] read this for login storage: https://auth0.com/blog/cookies-vs-tokens-definitive-guide/
- [ ] routing / redirection
- [ ] unit tests
- [ ] end to end tests
- [ ] remember me
- [ ] forgot password

### forms component
- [x] unit tests [8/26/2017]
- [x] removed btn glow [8/26/2017]
- [ ] refactor tests for easier maintainability
- [ ] comment components
- [ ] end to end tests?

### to do 
- [ ] improve application structure to something scalable and maintainable (redux_)
- [ ] implement react router
- [ ] implement cookie storage after valid login
- [ ] need a proper release cycle to stage and prod
- [ ] redux
- [ ] add a task runner for version bumping

### issues
- [x] form component paths [8/26/2017]
- [x] login component should allow the enter key [8/26/2017]
- [ ] unable to proxy requests to api server
	- [ ] able to make request to local backend server, but still having issue