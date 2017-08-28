# GSCP Client
client side to GSCP API

## client version 0.5.0

### to do 
- [ ] improve application structure to something scalable and maintainable (redux)
- [ ] implement react router
- [ ] need a proper release cycle to stage and prod
- [x] add a task runner for version bumping [8/27/2017]
- [ ] invest a day into cleaning up the entire client application

### login component
- [x] button states
- [x] button border
- [x] button text shadow
- [x] glyph icons
- [x] pull out form styles for separate component/stylesheet
- [x] add form validation [8/26/2017]
- [x] add validation for email addresses [8/26/2017]
- [x] interface with lumen API [8/27/2017]
- [x] read this for login storage: https://auth0.com/blog/cookies-vs-tokens-definitive-guide/ [8/27/2017]
- [x] https://stormpath.com/blog/where-to-store-your-jwts-cookies-vs-html5-web-storage [8/27/2017]
- [x] session handling should be stateless [8/27/2017]
- [x] implement some loading state for better perceived performance [8/27/2017]
- [x] improve the loading state with some animation... [8/27/2017]
- [ ] now might be a good time for sass
- [ ] now is a good time for redux
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

### issues
- [x] form component paths [8/26/2017]
- [x] login component should allow the enter key [8/26/2017]
- [x] unable to proxy requests to api server [8/27/2017]
- [x] 422 error when posting from login componet [8/27/2017]
- [ ] client should now throw an error in console