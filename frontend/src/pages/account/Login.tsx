import * as React from 'react';
import { Theme, withStyles, FormControl, InputLabel, Input, Button, MuiThemeProvider } from '@material-ui/core';
import Paper from '@material-ui/core/Paper';

class LoginPage extends React.Component<{}> {
    render(): JSX.Element {
        return (
            <div>
                <Paper>
                    <h2>{'Login'}</h2>
                    <FormControl required={true} fullWidth={true}>
                        <InputLabel htmlFor="username">Username</InputLabel>
                        <Input
                            id="username"
                        />
                    </FormControl>
                    <FormControl required={true} fullWidth={true}>
                        <InputLabel htmlFor="password">Password</InputLabel>
                        <Input
                            type="password"
                            id="password"
                        />
                    </FormControl>
                    <div>
                        <Button>
                            Login
                        </Button>
                    </div>
                </Paper>
            </div>
        );
    }
}

export default LoginPage;