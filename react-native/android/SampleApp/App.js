import React, {Fragment, Component, useState} from 'react';
import {
  SafeAreaView,
  StyleSheet,
  ScrollView,
  View,
  Text,
  Image,
  Button,
  StatusBar,
} from 'react-native';
import {
  Header,
  LearnMoreLinks,
  Colors,
  DebugInstructions,
  ReloadInstructions,
} from 'react-native/Libraries/NewAppScreen'

//Main 함수
const App = () => {
  const [isPressed, setIsPressed] = useState(true);

  return (
      <View style={styles.container}>
        <Text style={styles.redText}>Hello, world!!!</Text>
        <Photo type='sleep'></Photo>
        <Photo type='front'></Photo>

        <Button title={'나의 이름 출력'} onPress={()=>{setIsPressed(false)}}/>
        <Button title={'리셋'} onPress={()=>{setIsPressed(true)}}/>
        <Text> {isPressed ? '' : '해위~ 난 두식'} </Text>
      </View>
  )
}

//style 함수
const styles = StyleSheet.create({
  container:{
    flex: 1,
    justifyContent: 'center',
    alignItems: 'center'
  },
  redText: {
    color: 'red',
  }
});

//Photo 클래스
function Photo(props) {
  let dolImg = '';
  if(props.type==='sleep') {
    dolImg=require('./assets/sleep.jpg');
  } else if(props.type==='front') {
    dolImg=require('./assets/front.jpg');
  }
  return (
      <View>
        <Image
            source={dolImg}
            style={{width:200, height:200}}/>
      </View>
  )
}

export default App;