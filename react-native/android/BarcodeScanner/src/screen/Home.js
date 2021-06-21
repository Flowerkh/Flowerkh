import React, {Component} from 'react';
import {Button,Alert,View,SafeAreaView,PermissionsAndroid, Platform} from 'react-native';

export class Home extends Component {
    scanBarcode = () => {
        var that = this;

        if(Platform.OS === 'android') {
            async function requestCameraPermission() {
                try{
                    const granted = await PermissionsAndroid.request(
                        PermissionsAndroid.PERMISSIONS.CAMERA, {
                            'title' : '카메라 권한 요청',
                            'message' : '바코드를 스캔하기 위해 카메라 권한을 허용해주세요.'
                        }
                    )
                    if(granted === PermissionsAndroid.RESULTS.GRANTED) {
                        that.props.navigation.navigate('BarcodeScanner', {onGetBarcode : that.onGetBarcode })
                    } else {
                        alert('카메라 권한을 받지 못했습니다.');
                    }
                } catch(arr){
                    alert("카메라 권한 오류 : ", arr);
                    console.warn(err);
                }
            }
            //Calling the camera psermission function
            requestCameraPermission();
        } else {
            that.props.navigation.navigate('BarcodeScanner', {onGetBarcode: that.onGetBarcode })
        }
    }

    onGetBarcode = (barcodeValue) => {
        console.log("barcode value: ", barcodeValue);

        Alert.alert("barcode value: ", barcodeValue);
    };

    render() {
        return (
            <View style={{flex:1}}>
                <SafeAreaView style={{ flex:1, justifyContent: "center", alignItems: "center"}}>
                    <Button title="바코드 스캔" onPress={()=>this.scanBarcode()} />
                </SafeAreaView>
            </View>
        );
    }
}