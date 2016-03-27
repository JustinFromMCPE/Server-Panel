package com.Rocket_Scientist;

import com.google.gson.Gson;
import org.bouncycastle.util.io.pem.PemReader;
import javax.crypto.Cipher;
import java.io.*;
import java.net.ServerSocket;
import java.net.Socket;
import java.nio.file.Files;
import java.nio.file.StandardCopyOption;
import java.security.*;
import java.security.interfaces.RSAPublicKey;
import java.security.spec.PKCS8EncodedKeySpec;
import java.security.spec.X509EncodedKeySpec;
import java.util.ArrayList;
import java.util.List;
import java.util.Properties;

public class Main {

// Initialize new objects
public static Gson request = new Gson();
public static String[] formatted;
public static Process p;
public static int port;
public static int ram;
public static String panelDir;
public static String jar;
public static Boolean votifierEnabled;
public static String reward;
public static Socket client;
public static ServerSocket socket;
public static ServerSocket votifier;
public static Socket vote;
public static PublicKey pubKey;
public static PrivateKey privKey;
public static List<String> commandQueue = new ArrayList<>();

    static Thread MainThread = new Thread() {
        public void run() {
            while (true) {
                try {
                    Thread.sleep(50);
                    // Accept attempted client connections
                    client = socket.accept();
                    if (client.getInputStream() != null) {
                        OutputStream stdin = p.getOutputStream();
                        BufferedReader bf = new BufferedReader(new InputStreamReader(client.getInputStream()));
                        formatted = request.fromJson(bf.readLine(), String[].class);
                        BufferedWriter writer = new BufferedWriter(new OutputStreamWriter(stdin));
                        // Checks if the request contains a command
                        if (!formatted.equals(null)) {
                            if (formatted[1].equals("command")) {
                                writer.write(formatted[0]);
                                writer.newLine();
                                writer.flush();
                            }
                            // Checks if the request contains an action
                            else if (formatted[1].equals("action")) {
                                if (formatted[0].equals("stop") && p.isAlive()) {
                                    writer.write("stop");
                                    writer.newLine();
                                    writer.close();
                                } else if (formatted[0].equals("restart") && p.isAlive()) {
                                    try {
                                        writer.write("stop");
                                        writer.newLine();
                                        writer.close();
                                    } finally {
                                        p.destroy();
                                        first();
                                    }
                                } else if (formatted[0].equals("start") && !p.isAlive()) {
                                    first();
                                }
                            }
                            // Checks if the request contains a foreign action type
                            else {
                                // Do other thing
                            }
                        }
                    }
                } catch (Exception err) {
                }
            }
        }
    };
    static Thread CommandThread = new Thread() {
        public void run() {
            while (true) {
                try {
                    Thread.sleep(50);
                    if (!commandQueue.isEmpty()) {
                        OutputStream stdin = p.getOutputStream();
                        BufferedWriter writer = new BufferedWriter(new OutputStreamWriter(stdin));
                        writer.write(commandQueue.get(0));
                        writer.newLine();
                        writer.flush();
                        commandQueue.remove(0);
                    }
                } catch(Exception err){
                    err.printStackTrace();
                }
            }
        }
    };
    static Thread VoteThread = new Thread() {
        public void run() {
            while (true && votifierEnabled) {
                try {
                    vote = votifier.accept();
                    // Runs if there is an incoming connection
                    if (vote.getInputStream() != null) {
                        // Get info from stream
                        BufferedInputStream in = new BufferedInputStream(vote.getInputStream());
                        byte[] voteData = new byte[((RSAPublicKey) pubKey).getModulus().bitLength() / Byte.SIZE];
                        in.read(voteData);
                        // Decode info using private key
                        Cipher cipher = Cipher.getInstance("RSA/ECB/PKCS1Padding");
                        cipher.init(Cipher.DECRYPT_MODE, privKey);
                        byte[] data = cipher.doFinal(voteData);
                        String dataFormatted[] = new String(data, "UTF-8").split("\\r?\\n");
                        // Executes command
                        commandQueue.add(reward.replace("%p", dataFormatted[2]).replace("%s", dataFormatted[1]));
                    }
                } catch (Exception err) {
                    err.printStackTrace();
                }
            }
        }
    };

    public static void first() throws IOException {
        // Check for wrapper config
        if(!new File("config.properties").exists()) {
            PrintWriter writer = new PrintWriter("config.properties", "UTF-8");
            writer.println("port=8040");
            writer.println("panel-directory=");
            writer.close();
        }
        // Get wrapper config
        FileInputStream wc = new FileInputStream("config.properties");
        Properties properties = new Properties();
        properties.load(wc);
        port = Integer.parseInt(properties.getProperty("port"));
        panelDir = properties.getProperty("panel-directory");
        wc.close();
        // Check for panel config
        if(!new File(panelDir + "\\options.txt").exists()) {
            PrintWriter writer = new PrintWriter(panelDir + "\\options.txt", "UTF-8");
            writer.println("name=My Server");
            writer.println("username=21232f297a57a5a743894a0e4a801fc3");
            writer.println("password=5f4dcc3b5aa765d61d8327deb882cf99");
            writer.println("wrapper-port=" + Integer.toString(port));
            writer.println("server-jar=");
            writer.close();
        }

        // Get panel config
        FileInputStream pc = new FileInputStream(panelDir + "\\options.txt");
        properties = new Properties();
        properties.load(pc);
        jar = properties.getProperty("server-jar");
        pc.close();
        // Get votifier config
        FileInputStream vc = new FileInputStream(panelDir + "\\votifier-options.txt");
        properties.load(vc);
        votifierEnabled = Boolean.parseBoolean(properties.getProperty("enabled"));
        reward = properties.getProperty("reward");
        vc.close();
        // Check for keys
        if(!new File(panelDir + "\\public.key").exists() && !new File(panelDir + "\\public.key").exists() && votifierEnabled) {
            try {
                KeyPairGenerator keyPairGenerator = KeyPairGenerator.getInstance("RSA");
                keyPairGenerator.initialize(2048, new SecureRandom());
                KeyPair keypair = keyPairGenerator.generateKeyPair();
                PrintWriter writer = new PrintWriter(panelDir + "\\private.key");
                writer.println(keypair.getPrivate().toString());
                writer.close();
                writer = new PrintWriter(panelDir + "\\public.key");
                writer.println(keypair.getPublic().toString());
                writer.close();
            }
            catch (Exception err) {
                System.out.println("Error generating keys!");
            }
        }
        // Get keys
        FileInputStream vk = new FileInputStream(panelDir + "\\public.key");

        // Sync server.properties
        if(new File(panelDir + "\\server\\server.properties").exists()) {
            Files.copy(new File(panelDir + "\\server\\server.properties").toPath(), new File(".\\server\\server.properties").toPath(), StandardCopyOption.REPLACE_EXISTING);
        }
        else {
            Files.copy(new File(".\\server\\server.properties").toPath(), new File(panelDir + "\\server\\server.properties").toPath(), StandardCopyOption.REPLACE_EXISTING);
        }

        // Create new ProcessBuilder
        ProcessBuilder pb = new ProcessBuilder("java", "-jar", "..\\server\\minecraft_server.1.9.jar", "-Xmx" + Integer.toString(ram) + "G", "nogui");
        // Change work directory
        pb.directory(new File("server"));
        pb.redirectOutput(new File(panelDir + "\\log.txt"));
        // Start ProcessBuilder
        p = pb.start();
        socket = new ServerSocket(8040);
        votifier = new ServerSocket(8192);
        try {
            File pub = new File(panelDir + "\\public.key");
            File priv = new File(panelDir + "\\private.key");
            PemReader pubPemReader = new PemReader(new FileReader(pub));
            PemReader privPemReader = new PemReader(new FileReader(priv));
            X509EncodedKeySpec pubKeySpec = new X509EncodedKeySpec(pubPemReader.readPemObject().getContent());
            PKCS8EncodedKeySpec privKeySpec = new PKCS8EncodedKeySpec(privPemReader.readPemObject().getContent());
            KeyFactory kf = KeyFactory.getInstance("RSA");
            pubKey = kf.generatePublic(pubKeySpec);
            privKey = kf.generatePrivate(privKeySpec);

        }
        catch(Exception err) {
            err.printStackTrace();
        }
    }

    public static void main(String[] args) throws java.io.IOException {
        first();
        while(true) {
            try {
                MainThread.start();
                CommandThread.start();
                VoteThread.start();
                // Wait for completion
                MainThread.join();
                CommandThread.join();
                VoteThread.join();
            }
            catch (Exception err) {
                err.printStackTrace();

            }
        }
    }
}