package co.smartmeds.smartmeds;

import android.support.v7.app.ActionBarActivity;
import android.os.Bundle;
import android.text.Editable;
import android.view.Menu;
import android.view.MenuItem;
import android.view.View;
import android.widget.Button;
import android.widget.EditText;
import android.widget.TextView;

import com.firebase.client.DataSnapshot;
import com.firebase.client.Firebase;
import com.firebase.client.FirebaseError;
import com.firebase.client.ValueEventListener;

import org.json.JSONException;
import org.json.JSONObject;

import java.security.cert.X509Certificate;
import java.util.HashMap;


public class MainActivity extends ActionBarActivity {

    private EditText userID;
    private Button sendUserID;
    private Button logOutButton;

    private TextView userName;
    private String userNameString="";
    private String userIDString="default";
    private DataSnapshot healthData;
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

    public void homePageView() throws Exception{
        //display some text to indicate logged in
        userIDString = userID.getText().toString();
        Firebase ref = new Firebase("https://radiant-torch-4965.firebaseio.com/users/"+userIDString);

        ref.addValueEventListener(new ValueEventListener() {
            @Override

            public void onDataChange(DataSnapshot snapshot) {
                healthData = snapshot;

                userNameString = healthData.child("name").toString();
                System.out.println(userNameString);
            }
            @Override
            public void onCancelled(FirebaseError firebaseError) {
                System.out.println("The read failed: " + firebaseError.getMessage());
            }
        });

        userID.setVisibility(View.GONE);
        userID.setText("");
        userID.setEnabled(false);
        userID.setClickable(false);
        sendUserID.setVisibility(View.GONE);
        logOutButton.setVisibility(View.VISIBLE);

        userName.setVisibility(View.VISIBLE);
        userName.setText(userNameString);
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
