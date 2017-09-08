# GSCP Client
client side to GSCP API

## client version 0.10.0

### to do
- [x] improve application structure to something scalable and maintainable (redux) [8/28/2017]
	- [ ] http://redux.js.org/docs/recipes/ReducingBoilerplate.html
	- [ ] normalize data
	- [ ] normalize es6/7 api
- [x] implement react router https://reacttraining.com/react-router/web/example/auth-workflow
    - [x] learn how to unit test router with redux [9/7/2017]
    - [ ] e2e/integration test router & redux
- [ ] need a proper release cycle from dev to stage and prod
- [ ] now might be a good time for sass
- [x] add a task runner for version bumping [8/27/2017]
- [ ] invest a day into cleaning up the entire client application
	- [ ] performance
	- [ ] comments/documenting
	- [ ] refactoring
- [ ] rewrite client utility as a proper es6/7 class
    - [ ] comment/document
- [ ] add a working linter & rules to ST3
- [ ] context whitelisting?
- [ ] refactor & improve naming convention

### app component [coverage: partial]
- [x] unit tests [8/30/2017]
- [x] comment / clean up / refactor / prop types / default props [8/31/2017]
- [x] refactor tests to account for react router & redux [9/7/2017]
- [ ] integration tests to assert components render when the route changes...
- [ ] app component should be moved to a container to include auth logic so sidebar and header can be hidden

### dashboard component [coverage: complete]
- [x] unit tests [9/7/2017]
- [x] comment [9/7/2017]
- [ ] component should render:
    - [x] sidebar [9/8/2017]
    - [x] header [9/8/2017]
    - [ ] list: should be dynamic depending on chosen module

### forms component [coverage: complete]
- [x] unit tests [8/26/2017]
- [x] removed btn glow [8/26/2017]
- [x] prop types & default props [9/6/2017]
- [x] comment / document [9/6/2017]

### header container
- [ ] logic for displaying correct modules based on roles/permissions
- [ ] logic for getting user info (details, role, permissions)

### header component
- [ ] active classes
- [ ] tests
- [ ] finish styling

### list [coverage: none]
- [x] comment/document
- [ ] proptypes/default props
- [ ] lint/format
- [ ] performance
- [ ] tests

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
    - [x] https://medium.com/@dan_abramov/smart-and-dumb-components-7ca2f9a7c7d0
        - [x] move container component back into container folder so that presentation is fully separated from container components [9/6/2017]
    - [ ] https://gist.github.com/chantastic/fc9e3853464dffdb1e3c
- [x] prop types & default props
- [x] improve email validation [9/6/2016]
- [ ] unit tests
- [ ] end to end tests
- [ ] remember me
- [ ] forgot password

### sidebar container
- [ ] logic for displaying correct modules based on roles/permissions
- [ ] logic for getting user info (details, role, permissions)

### sidebar component
- [ ] active classes
- [ ] tests
- [ ] finish styling

### issues
- [x] form component paths [8/26/2017]
- [x] login component should allow the enter key [8/26/2017]
- [x] unable to proxy requests to api server [8/27/2017]
- [x] 422 error when posting from login componet [8/27/2017]
- [x] client should not throw an error in console [8/30/2017]
- [x] token is not available in container [8/30/2017]
- [x] app is rendering both components when hitting /dashboard [9/6/2017]
- [x] react-router is not rendering component passed to route component [9/8/2017]
