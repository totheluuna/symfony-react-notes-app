import * as React from 'react';
import { Theme, withStyles, FormControl, InputLabel, Input, InputAdornment, Button, Icon } from '@material-ui/core';
import Paper from '@material-ui/core/Paper';


class SignUpPage extends React.Component<{}> {
    render(): JSX.Element {
        return (
            <div>
                <Paper>
                    <h2>{'Sign Up'}</h2>
                    <FormControl required={true} fullWidth={true}>
                        <InputLabel htmlFor="username">Username</InputLabel>
                        <Input
                            id="username"
                        />
                    </FormControl>
                    <FormControl required={true} fullWidth={true}>
                        <InputLabel htmlFor="email">Email Address</InputLabel>
                        <Input
                            id="email"
                        />
                    </FormControl>
                    <FormControl required={true} fullWidth={true}>
                        <InputLabel htmlFor="password">Password</InputLabel>
                        <Input
                            type="password"
                            id="password"
                        />
                    </FormControl>
                    <FormControl required={true} fullWidth={true}>
                        <InputLabel htmlFor="retypedPassword">Re-type Password</InputLabel>
                        <Input
                            type="password"
                            id="retypedPassword"
                        />
                    </FormControl>
                    <FormControl required={true} fullWidth={true}>
                        <InputLabel htmlFor="name">Full Name</InputLabel>
                        <Input
                            id="name"
                        />
                    </FormControl>
                    <div>
                        <Button>
                            Cancel
                        </Button>
                        <Button>
                            Submit
                        </Button>
                    </div>
                </Paper>
            </div>
        );
    }
}

export default SignUpPage;