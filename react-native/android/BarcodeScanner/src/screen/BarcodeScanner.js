import React, {Component} from 'react';
import { View, PermissionsAndroid, Platform} from 'react-native';
import {CameraScreen } from 'react-native-camera-kit';

var isFirstGet = true;

export class BarcodeScanner extends Component {
    constructor(props) {
        super(props);
    };

    componentDidMount() {
        isFirstGet = true;
    }
    componentWillUnmount() {

    }

    /** 
     * 바코드 스캔 
     * */

    onBarcodeScan(barcodeValue) {
        console.log("onBarcodeScan");
        if(!isFirstGet){
            return
        }

        isFirstGet = false;
        this.props.route.params.onGetBarcode(barcodeValue);
        //TODO 필요한 부분 구현
        this.props.navigation.navigate('Home');

        console.log("scanned barcode value: "+ barcodeValue);
    }

    //TODO Home.js로 이동시켜주세요
    checkCameraPermission() {

    }

    render() {
        return (
            <View style={{flex: 1}}>
                <CameraScreen
                showFrame={true}
                scanBarcode={true}
                laserColor={'blue'}
                frameColor={'yellow'}
                colorForScannerFrame={'black'}
                onReadCode={event => this.onBarcodeScan(event.nativeEvent.codeStringValue)
                }
                />
            </View>
        )
    }
}