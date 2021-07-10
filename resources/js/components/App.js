import React from 'react'
import ReactDOM from "react-dom";
import ImageUploader from "./ImageUploader";
import FlashMessage from "./FlashMessage";

class App extends React.Component {
    constructor(props) {
        super(props);

        this.state = {
            flashMessage: {}
        }

        this.updateFlashMessage = this.updateFlashMessage.bind(this);
    }

    updateFlashMessage = (message) => {
        this.setState({flashMessage: message});

        setTimeout(() => {
            this.setState({flashMessage: {}});
        }, 2000);
    }

    render() {
        return (
            <>
                <FlashMessage message={this.state.flashMessage} />
                <ImageUploader updateFlashMessage={this.updateFlashMessage} />
            </>
        );
    }
}

export default App;

if (document.getElementById('app')) {
    ReactDOM.render(<App />, document.getElementById('app'));
}
