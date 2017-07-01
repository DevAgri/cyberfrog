#include <Adafruit_BMP085.h>
#include <Wire.h>
#include <dht.h>
#include <LiquidCrystal.h>
#include <SoftwareSerial.h>  

#define BTN_DISPLAY 6
#define LCD_DISPLAY 7
#define LUMINOSIDADE A0
#define TEMP_UMI A1
#define UMIDADE_SOLO A7
#define VENTO A3

// em cm
#define DIAMETRO 9

dht DHT;
Adafruit_BMP085 bmp180;

//Inicializando as portas de dados do display 
LiquidCrystal lcd(12, 11, 5, 4, 3, 2); 

void setup() {
  pinMode(LUMINOSIDADE, INPUT);
  pinMode(TEMP_UMI, INPUT);
  pinMode(UMIDADE_SOLO, INPUT);
  pinMode(VENTO, INPUT);
  pinMode(BTN_DISPLAY, INPUT);
  pinMode(LCD_DISPLAY, OUTPUT);

  // impressao em porta USB
  Serial.begin(9600);
  // impressao em porta bluetooth
  Serial1.begin(9600);
  
  bmp180.begin();
  digitalWrite(LCD_DISPLAY, LOW);
}

void loop() {
  DHT.read11(TEMP_UMI);

  int umidade;
  umidade = analogRead(UMIDADE_SOLO);
  umidade = map(umidade, 1023, 0, 0, 100);

  if (Serial1.available()) {
    char x = Serial1.read();
    Serial.println("Qualquer coisa");

    if (x == 'f') {
      String text = "@";
      text += analogRead(LUMINOSIDADE);
      text += ";";
      text += DHT.temperature;
      text += ";";
      text += bmp180.readTemperature();
      text += ";";
      text += DHT.humidity;
      text += ";";
      text += umidade;
      text += ";";
      text += bmp180.readPressure();
      text += "#";
      Serial1.println(text);
    }
  }
  
  
  if (digitalRead(BTN_DISPLAY) == HIGH) {
    lcd.begin(16, 2);
    digitalWrite(LCD_DISPLAY, HIGH);
    
    // Print a message to the LCD.
    lcd.print("Cyber Frog!");
    delay(3000);
  
    lcd.clear();
    lcd.setCursor(0, 0);
    lcd.print("LUMINOSIDADE: ");
    lcd.setCursor(0, 1);
    lcd.print(analogRead(LUMINOSIDADE));
    lcd.print(" lm");
    
    delay(5000);
    lcd.clear();

    lcd.setCursor(0, 0);
    lcd.print("TEMPERATURA INT: ");
    lcd.setCursor(0, 1);
    lcd.print(DHT.temperature);
    lcd.print(" C");

    delay(5000);
    lcd.clear();

    lcd.setCursor(0, 0);
    lcd.print("TEMPERATURA: ");
    lcd.setCursor(0, 1);
    lcd.print(bmp180.readTemperature());
    lcd.print(" C");

    delay(5000);
    lcd.clear();

    lcd.setCursor(0, 0);
    lcd.print("UMIDADE: ");
    lcd.setCursor(0, 1);
    lcd.print(DHT.humidity);
    lcd.print(" %");
    
    delay(5000);
    lcd.clear();

    lcd.setCursor(0, 0);
    lcd.print("UMIDADE SOLO: ");
    lcd.setCursor(0, 1);
    lcd.print(umidade);
    lcd.print(" %");
    
    delay(5000);
    lcd.clear();
      
    lcd.setCursor(0, 0);
    lcd.print("PRESSAO ATM: ");
    lcd.setCursor(0, 1);
    lcd.print(bmp180.readPressure());
    lcd.print(" pa");

    delay(5000);

  }else{
    lcd.noDisplay();
    digitalWrite(LCD_DISPLAY, LOW);
  }
}
