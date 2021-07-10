import React from 'react'

const FlashMessage = ({message}) => {
    return (
        <>
        {Object.keys(message).length !== 0 && (
            <div className="flash-container">
                <div className={`flash-body ${message.status === 'error' ? "flash-danger" : "flash-success"}`}>
                    {message.message}
                </div>
            </div>
        )}
        </>
    )
}

export default FlashMessage;
