package co.smartmeds.smartmeds;

import android.app.Activity;
import android.app.AlarmManager;
import android.app.PendingIntent;
import android.content.Context;
import android.content.Intent;

import android.os.Bundle;
import android.view.Menu;
import android.view.MenuItem;
import android.view.View;
import android.widget.Button;
import android.widget.EditText;
import android.widget.TextView;
import android.widget.Toast;

import com.firebase.client.DataSnapshot;
import com.firebase.client.Firebase;
import com.firebase.client.FirebaseError;
import com.firebase.client.ValueEventListener;

import org.json.JSONException;
import org.json.JSONObject;

import java.security.cert.X509Certificate;
import java.util.Calendar;
import java.util.HashMap;


public class MainActivity extends Activity {

    private EditText userID;
    private Button sendUserID;
    private Button logOutButton;

    private TextView userName;
    private String userNameString="";
    private String userIDString="default";
    private String medicine="";
    private String company="";
    private String dosage="";
    private int Interval;
    private int Offset;



    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_main);
        Firebase.setAndroidContext(this);

        userID = (EditText) findViewById(R.id.user);
        userName = (TextView) findViewById(R.id.userName);

        sendUserID = (Button) findViewById(R.id.sendUser);
        View.OnClickListener sendUserListener = new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                try {
                    homePageView();
                } catch (Exception e) {
                    e.printStackTrace();
                }
            }
        };
        sendUserID.setOnClickListener(sendUserListener);

        logOutButton = (Button) findViewById(R.id.logOut);
        View.OnClickListener logOutListener = new View.OnClickListener(){
            @Override
            public void onClick(View v){
                logInView();
            }
        };
        logOutButton.setOnClickListener(logOutListener);

        logInView();
    }

    public void start() {
        Calendar cal = Calendar.getInstance();
        //Create a new PendingIntent and add it to the AlarmManager
        Intent intent = new Intent(this, AlarmReceiver.class);
        PendingIntent pendingIntent = PendingIntent.getBroadcast(this,
                12345, intent, PendingIntent.FLAG_CANCEL_CURRENT);
        AlarmManager am = (AlarmManager)getSystemService(Activity.ALARM_SERVICE);
        am.setRepeating(AlarmManager.RTC_WAKEUP, cal.getTimeInMillis(),Interval*1000,
                pendingIntent);
    }
    /*public void cancel() {
        AlarmManager manager = (AlarmManager) getSystemService(Context.ALARM_SERVICE);
        manager.cancel(pendingIntent);
        Toast.makeText(this, "Alarm Canceled", Toast.LENGTH_SHORT).show();
    }*/
    public void homePageView() throws Exception{
        //display some text to indicate logged in
        userIDString = userID.getText().toString().trim();
        System.out.println(userIDString+"userIDString");
        Firebase ref = new Firebase("https://radiant-torch-4965.firebaseio.com/users/"+userIDString);

        ref.addValueEventListener(new ValueEventListener() {
            @Override

            public void onDataChange(DataSnapshot snapshot) {
                userNameString = snapshot.child("name").getValue().toString();
                Interval = Integer.parseInt(snapshot.child("plans/0/interval").getValue().toString());
                Offset = Integer.parseInt(snapshot.child("plans/0/offset").getValue().toString());
                medicine=snapshot.child("plans/0/med/name").getValue().toString();
                dosage=snapshot.child("plans/0/dose").getValue().toString();
                company=snapshot.child("plans/0/med/manufacturer").getValue().toString();
                System.out.println(userNameString);
                userID.setVisibility(View.GONE);
                userID.setText("");
                userID.setEnabled(false);
                userID.setClickable(false);
                sendUserID.setVisibility(View.GONE);
                logOutButton.setVisibility(View.VISIBLE);
                userName.setText(userNameString);
                userName.setVisibility(View.VISIBLE);
                System.out.println("hello world"+userNameString);
                //createAlarm();
                start();
            }
            @Override
            public void onCancelled(FirebaseError firebaseError) {
                System.out.println("The read failed: " + firebaseError.getMessage());
            }
        });
    }
    public void logInView(){
        userID.setVisibility(View.VISIBLE);
        userID.setEnabled(true);
        userID.setClickable(true);
        sendUserID.setVisibility(View.VISIBLE);

        userName.setVisibility(View.GONE);
        logOutButton.setVisibility(View.GONE);
    }
    @Override
    public boolean onCreateOptionsMenu(Menu menu) {
        // Inflate the menu; this adds items to the action bar if it is present.
        getMenuInflater().inflate(R.menu.menu_main, menu);
        return true;
    }

    @Override
    public boolean onOptionsItemSelected(MenuItem item) {
        // Handle action bar item clicks here. The action bar will
        // automatically handle clicks on the Home/Up button, so long
        // as you specify a parent activity in AndroidManifest.xml.
        int id = item.getItemId();

        //noinspection SimplifiableIfStatement
        if (id == R.id.action_settings) {
            return true;
        }

        return super.onOptionsItemSelected(item);
    }
}
