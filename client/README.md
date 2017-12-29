# GSCP Client
client side to GSCP API

## client version 0.14.0

## to do
- [x] improve application structure to something scalable and maintainable (redux) [8/28/2017]
	- [x] http://redux.js.org/docs/recipes/ReducingBoilerplate.html [9/12/2017]
    - [ ] https://www.youtube.com/watch?v=xsSnOQynTHs
	- [ ] normalize data
	- [ ] normalize es6/7 api with a polyfill
- [x] implement react router https://reacttraining.com/react-router/web/example/auth-workflow
    - [x] learn how to unit test router with redux [9/7/2017]
    - [ ] e2e/integration test router & redux
- [ ] need a proper release cycle from dev to stage and prod
- [ ] now might be a good time for sass?
- [x] add a task runner for version bumping [8/27/2017]
- [ ] rewrite client utility as a proper es6/7 class
    - [ ] comment/document
- [x] add a working linter & rules to ST3 on mac [9/12/2017]
- [ ] add auto-formatting for jsx to st3 on mac
- [ ] update lint rules to match mac on pc
- [ ] update formatting rules to match mac on pc
- [ ] context whitelisting?
- [x] new Wrapper container to handle all auth and redirect logic [9/11/2017]
    - [ ] this doesn't really seem like such a good pattern yet...
- [x] add a catch-all that redirects to dashboard [9/9/2017]
- [ ] logout component
- [ ] invest a day into cleaning up the entire client application
    - [ ] performance
    - [ ] comments/documenting
    - [ ] refactoring
        - [ ] refactor naming convention to remove *Container from container names and add *View to components instead of *Component? --this could make the app more difficult to reason about
        - [ ] find a better solution to redirecting to /login and perhaps just hide header/siderbar/ and all other applicable components and just display the login component?
- [ ] refactor actions to something more maintainable, possibly move them into the reducer folder and have a folder for each reducer, actions and action creators
- [ ] determine if the wrapper needs to be a container or component?
- [ ] revalidate proptypes for token and isloggedout considering token is both boolean and string


## components
### app component [coverage: partial]
- [x] unit tests [8/30/2017]
- [x] comment / clean up / refactor / prop types / default props [8/31/2017]
- [x] refactor tests to account for react router & redux [9/7/2017]
- [x] refactor app component [9/8/2017]
- [x] refactor unit tests [9/12/2017]

### container component [coverage: complete]
- [x] comment [9/11/2017]
- [x] proptypes [9/11/2017]
- [x] rename this component [9/11/2017]
- [x] tests [9/12/2017]

### dashboard component [coverage: incomplete]
- [x] unit tests [9/7/2017]
- [x] comment [9/7/2017]
- [x] refactor dashboard component [9/8/2017]
- [ ] refactor unit tests (not important atm)...

### forms component [coverage: complete]
- [x] unit tests [8/26/2017]
- [x] removed btn glow [8/26/2017]
- [x] prop types & default props [9/6/2017]
- [x] comment / document [9/6/2017]

### header component
- [x] add header component [9/8/2017]
- [x] document [9/11/2017]
- [ ] active classes for nav
- [ ] tests
- [ ] finish styling

### list component [coverage: none]
- [x] add list component [9/8/2017]
- [x] comment/document list component [9/8/2017]
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
    - [x] https://gist.github.com/chantastic/fc9e3853464dffdb1e3c
- [x] prop types & default props
- [x] improve email validation [9/6/2016]
- [x] refactor loading classes and use classname package [9/11/2017]
- [x] comments [9/11/2017]
- [ ] unit tests
- [ ] end to end tests
- [ ] remember me
- [ ] forgot password


### tables components
- [ ] comments
- [ ] proptypes
- [ ] tests

## containers
### header container
- [x] create header container [9/9/2017]
- [ ] logic for displaying correct modules based on roles/permissions
- [ ] logic for getting user info (details, role, permissions)
- [ ] document

### sidebar container
- [x] add sidebar container [9/8/2017]
- [ ] logic for displaying correct modules based on roles/permissions
- [ ] logic for getting user info (details, role, permissions)

### sidebar component
- [x] add sidebar component [9/8/2017]
- [ ] active classes
- [ ] tests
- [ ] finish styling

### wrapper container
- [ ] change this to a container and put auth/redirect logic here...
- [ ] tests
- [ ] comments
- [ ] proptypes

## issues
- [x] form component paths [8/26/2017]
- [x] login component should allow the enter key [8/26/2017]
- [x] unable to proxy requests to api server [8/27/2017]
- [x] 422 error when posting from login componet [8/27/2017]
- [x] client should not throw an error in console [8/30/2017]
- [x] token is not available in container [8/30/2017]
- [x] app is rendering both components when hitting /dashboard [9/6/2017]
- [x] react-router is not rendering component passed to route component [9/8/2017]
- [ ] mobile menu should close when the route changes or when user clicks on a link
- [ ] issue with full height elements on login screen
