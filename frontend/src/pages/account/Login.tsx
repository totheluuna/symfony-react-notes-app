import * as React from 'react';
import { Theme, withStyles, FormControl, InputLabel, Input, Button, TextField} from '@material-ui/core';
import Paper from '@material-ui/core/Paper';

interface Props {
    classes: any;
}

class LoginPage extends React.Component<Props> {
    render(): JSX.Element {
        const classes = this.props.classes;
        return (
            <div className={classes.container}>
                <Paper className={classes.paper}>
                    <h2>{'Login'}</h2>
                    <FormControl required={true} fullWidth={true} className={classes.field}>
                        <TextField
                            id="username"
                            label="Username"
                            variant="outlined"
                        />
                    </FormControl>
                    <FormControl required={true} fullWidth={true} className={classes.field}>
                        <TextField
                            id="password"
                            label="Password"
                            variant="outlined"
                            type="password"
                        />
                    </FormControl>
                    <div className={classes.actions}>
                        <Button
                            variant="contained"
                            color="primary"
                            className={classes.button}>
                            Login
                        </Button>
                        <Button
                            variant="contained"
                            color="secondary"
                            className={classes.button}>
                            Sign Up
                        </Button>
                    </div>
                </Paper>
            </div>
        );
    }
}

const styles = (theme: Theme) => ({
    container: {
        display: 'flex',
        justifyContent: 'center'
    },
    paper: theme.mixins.gutters({
        paddingTop: 16,
        paddingBottom: 16,
        marginTop: theme.spacing(3),
        width: '20%',
        display: 'flex',
        flexDirection: 'column',
        alignContent: 'center',
        [theme.breakpoints.down('md')]: {
            width: '100%',
        },
    }),
    field: {
        marginTop: theme.spacing(2)
    },
    actions: theme.mixins.gutters({
        paddingTop: 16,
        paddingBottom: 16,
        marginTop: theme.spacing(3),
        marginLeft: theme.spacing(10),
        marginRight: theme.spacing(5),
        display: 'flex',
        flexDirection: 'row',
        alignContent: 'center'
    }),
    button: {

        // marginTop: theme.spacing(5),
        marginRight: theme.spacing(2)
    },
});

export default withStyles(styles, { withTheme: true })(LoginPage as any) as any;