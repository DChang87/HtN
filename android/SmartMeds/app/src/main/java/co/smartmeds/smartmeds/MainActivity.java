package co.smartmeds.smartmeds;

import android.annotation.TargetApi;
import android.app.Activity;
import android.app.AlarmManager;
import android.app.PendingIntent;
import android.content.Context;
import android.content.Intent;

import android.content.SharedPreferences;
import android.os.Build;
import android.os.Bundle;
import android.view.Menu;
import android.view.MenuItem;
import android.view.View;
import android.widget.ArrayAdapter;
import android.widget.Button;
import android.widget.EditText;
import android.widget.LinearLayout;
import android.widget.ListView;
import android.widget.TextView;
import android.widget.Toast;

import com.firebase.client.DataSnapshot;
import com.firebase.client.Firebase;
import com.firebase.client.FirebaseError;
import com.firebase.client.ValueEventListener;

import org.json.JSONException;
import org.json.JSONObject;

import java.security.cert.X509Certificate;
import java.text.ParseException;
import java.text.SimpleDateFormat;
import java.util.ArrayList;
import java.util.Calendar;
import java.util.Date;
import java.util.HashMap;


public class MainActivity extends Activity {

    private EditText userID;
    private Button sendUserID;
    private Button logOutButton;
    private int planId;
    private LinearLayout in;
    private LinearLayout signin;
    private TextView userName;
    private String plan="";
    private String date="";
    private String userNameString="";
    private String userIDString="default";
    private String medicine="";
    private String company="";
    private String dosage="";
    private int repeats = 0;
    private int Interval;
    private int Offset;



    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(null);
        setContentView(R.layout.activity_main);
        Firebase.setAndroidContext(this);
        SharedPreferences settings = getApplicationContext().getSharedPreferences("accountPrefs", 0);
        userID = (EditText) findViewById(R.id.user);
        userName = (TextView) findViewById(R.id.userName);
        in = (LinearLayout) findViewById(R.id.in);
        signin = (LinearLayout) findViewById(R.id.signin);
        sendUserID = (Button) findViewById(R.id.sendUser);
        View.OnClickListener sendUserListener = new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                try {
                    userIDString = userID.getText().toString().trim();
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

        if(settings.contains("user")){
            userIDString = settings.getString("user", "");
            try {
                homePageView();
            } catch (Exception e) {
                e.printStackTrace();
            }
            return;
        }else {
            logInView();
        }
    }
    public String getHash(int v){
        return userNameString+"-"+planId+"-"+v;
    }
    @TargetApi(Build.VERSION_CODES.KITKAT)
    public void start() throws ParseException {

        SharedPreferences settings = getApplicationContext().getSharedPreferences("accountPrefs", 0);
        SharedPreferences.Editor editor = settings.edit();
        Calendar cal = Calendar.getInstance();
        //Create a new PendingIntent and add it to the AlarmManager
        Intent intent = new Intent(this, AlarmReceiver.class);
        intent.putExtra("name", userNameString);
        intent.putExtra("medicine", medicine);
        intent.putExtra("company", company);
        intent.putExtra("dose", dosage);
        AlarmManager am = (AlarmManager)getSystemService(Activity.ALARM_SERVICE);
        System.out.println("Repeats: " + repeats);
        System.out.println("Interval: " + Interval);

        ArrayList<Item> arrayOfUsers = new ArrayList<Item>();
// Create the adapter to convert the array to views
        for(int i = 1; i <= repeats; i++){
            Date d = new SimpleDateFormat("yyyy-MM-dd HH:mm:ss").parse(date);
            d = new Date(d.getTime() + 3600000 * Offset + 3600000 * Interval * i);
            if(d.getTime() > cal.getTimeInMillis() && d.getTime() < cal.getTimeInMillis() + 604800000) arrayOfUsers.add(new Item(medicine, plan + " | " + company, new SimpleDateFormat("ccc LLL L @ h:mma").format(d)));
            if(settings.contains(getHash(i))) continue;
            PendingIntent pendingIntent = PendingIntent.getBroadcast(this,
                  i*12345, intent, PendingIntent.FLAG_CANCEL_CURRENT);
            editor.putBoolean(getHash(i), true);
            editor.apply();
            am.setExact(AlarmManager.RTC_WAKEUP, cal.getTimeInMillis() + Interval * 1000 * i,
                    pendingIntent);
        }
        ItemAdapter adapter = new ItemAdapter(this, arrayOfUsers);
// Attach the adapter to a ListView
        ListView listView = (ListView) findViewById(R.id.mainList);
        listView.setAdapter(adapter);
    }
    /*public void cancel() {
        AlarmManager manager = (AlarmManager) getSystemService(Context.ALARM_SERVICE);
        manager.cancel(pendingIntent);
        Toast.makeText(this, "Alarm Canceled", Toast.LENGTH_SHORT).show();
    }*/
    public void homePageView() throws Exception{
        signin.setVisibility(View.GONE);
        in.setVisibility(View.VISIBLE);
        userID.setText("");
        userID.setEnabled(false);
        userName.setText("Loading...");
        //display some text to indicate logged in
        Firebase ref = new Firebase("https://radiant-torch-4965.firebaseio.com/users/"+userIDString);

        SharedPreferences settings = getApplicationContext().getSharedPreferences("accountPrefs", 0);
        SharedPreferences.Editor editor = settings.edit();
        editor.putString("user", userIDString);
        editor.apply();
        ref.addValueEventListener(new ValueEventListener() {
            @Override

            public void onDataChange(DataSnapshot snapshot) {
                System.out.println(snapshot.child("plans").getChildrenCount());
                for(int i = 0; i < snapshot.child("plans").getChildrenCount(); i++) {
                    userNameString = snapshot.child("name").getValue().toString();
                    Interval = Integer.parseInt(snapshot.child("plans/" + i + "/interval").getValue().toString());
                    planId = Integer.parseInt(snapshot.child("plans/"+i+"/id").getValue().toString());
                    Offset = Integer.parseInt(snapshot.child("plans/"+i+"/offset").getValue().toString());
                    medicine = snapshot.child("plans/"+i+"/med/name").getValue().toString();
                    dosage = snapshot.child("plans/"+i+"/dose").getValue().toString();
                    company = snapshot.child("plans/"+i+"/med/manufacturer").getValue().toString();
                    plan = snapshot.child("plans/"+i+"/name").getValue().toString();

                    date = snapshot.child("plans/"+i+"/created_at").getValue().toString();
                    repeats = Integer.parseInt(snapshot.child("plans/"+i+"/repeats").getValue().toString());
                    try {
                        start();
                    } catch (ParseException e) {
                        e.printStackTrace();
                    }
                }
                //THIS runS AFTER PERSON LOGS IN
                userName.setText("Signed in as " + userNameString);

            }
            @Override
            public void onCancelled(FirebaseError firebaseError) {
                System.out.println("The read failed: " + firebaseError.getMessage());
            }
        });
    }
    public void logInView(){

        SharedPreferences settings = getApplicationContext().getSharedPreferences("accountPrefs", 0);
        if(settings.contains("user")){
            SharedPreferences.Editor editor = settings.edit();
            editor.remove("user");
            editor.apply();
        }
        userID.setEnabled(true);
        userID.requestFocus();
        signin.setVisibility(View.VISIBLE);
        in.setVisibility(View.GONE);
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
