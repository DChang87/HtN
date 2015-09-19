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

import com.firebase.client.Firebase;


public class MainActivity extends ActionBarActivity {

    private EditText userID;
    private Button sendUserID;
    private Button logOutButton;
    private TextView userName;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        Firebase.setAndroidContext(this);
        final Firebase rootRef = new Firebase("https://docs-examples.firebaseio.com/web/data/users/mchen/name");
        setContentView(R.layout.activity_main);
        userID = (EditText) findViewById(R.id.user);
        sendUserID = (Button) findViewById(R.id.sendUser);
        View.OnClickListener sendUserListener = new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                //obtain data and check
                //userName.setText("User Name: "+userID.getText().toString());
                userName.setText("User Name: "+rootRef);
                homePageView();
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
        userName = (TextView) findViewById(R.id.userNameID);
        logInView();
    }

    public void homePageView(){
        //display some text to indicate logged in
        userID.setVisibility(View.GONE);
        userID.setEnabled(false);
        userID.setClickable(false);
        sendUserID.setVisibility(View.GONE);
        logOutButton.setVisibility(View.VISIBLE);
        userName.setVisibility(View.VISIBLE);

        userID.setText("");
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
