# GSCP Client
client side to GSCP API

## client version 0.7.0

### to do
- [x] improve application structure to something scalable and maintainable (redux) [8/28/2017]
	- [ ] http://redux.js.org/docs/recipes/ReducingBoilerplate.html
	- [ ] normalize data
	- [ ] normalize es6/7 api
- [ ] implement react router https://reacttraining.com/react-router/web/example/auth-workflow
- [ ] need a proper release cycle from dev to stage and prod
- [ ] now might be a good time for sass
- [x] add a task runner for version bumping [8/27/2017]
- [ ] invest a day into cleaning up the entire client application
	- [ ] performance
	- [ ] comments/documenting
	- [ ] refactoring

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
- [x] container / presentational components: [8/29/2017]
    - [x] https://www.youtube.com/watch?v=KYzlpRvWZ6c&t=1351
    - [x] https://medium.com/@learnreact/container-components-c0e67432e005
    - [ ] https://medium.com/@dan_abramov/smart-and-dumb-components-7ca2f9a7c7d0
    - [ ] https://gist.github.com/chantastic/fc9e3853464dffdb1e3c
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
- [ ] client should not throw an error in console