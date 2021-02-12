import * as React from 'react';
import './App.css';
import blue from '@material-ui/core/colors/blue';
import { createMuiTheme, MuiThemeProvider } from '@material-ui/core';
import { pink } from '@material-ui/core/colors';
import LoginPage from './pages/account/Login';
import SignUpPage from './pages/account/SignUp';

const theme = createMuiTheme({
  palette: {
    primary: blue,
    secondary: pink
  }
})
class App extends React.Component {
  public render() {
    return (
      <MuiThemeProvider theme={theme}>
        <SignUpPage />
      </MuiThemeProvider>
    );
  }
}

export default App;
