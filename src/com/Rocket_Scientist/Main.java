package com.Rocket_Scientist;

import com.google.gson.Gson;
import com.sun.crypto.provider.RSACipher;
import sun.misc.BASE64Decoder;

import javax.crypto.BadPaddingException;
import javax.crypto.Cipher;
import javax.crypto.IllegalBlockSizeException;
import javax.crypto.NoSuchPaddingException;
import java.io.*;
import java.net.ServerSocket;
import java.net.Socket;
import java.nio.file.Files;
import java.nio.file.StandardCopyOption;
import java.security.*;
import java.security.interfaces.RSAPrivateKey;
import java.security.spec.PKCS8EncodedKeySpec;
import java.util.Base64;
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
public static String serverPort;
public static String map;
public static Socket client;
public static ServerSocket socket;
public static ServerSocket votifier;
public static Socket vote;

    public static PrivateKey readPrivateKey(File keyFile) throws Exception {
        // read key bytes
        FileInputStream in = new FileInputStream(keyFile);
        byte[] keyBytes = new byte[in.available()];
        in.read(keyBytes);
        in.close();

        String privateKey = new String(keyBytes, "UTF-8");
        privateKey = privateKey.replaceAll("(-+BEGIN RSA PRIVATE KEY-+\\r?\\n|-+END RSA PRIVATE KEY-+\\r?\\n?)", "");

        // don't use this for real projects!
        BASE64Decoder decoder = new BASE64Decoder();
        keyBytes = decoder.decodeBuffer(privateKey);

        // generate private key
        PKCS8EncodedKeySpec spec = new PKCS8EncodedKeySpec(keyBytes);
        KeyFactory keyFactory = KeyFactory.getInstance("RSA");
        return keyFactory.generatePrivate(spec);
    }
    public static void first() throws IOException {

        // Check for wrapper config
        if(!new File("config.properties").exists()) {
            PrintWriter writer = new PrintWriter("config.properties", "UTF-8");
            writer.println("port=8040");
            writer.println("panel-directory=");
            writer.close();
        }
        // Check for private key
        if(!new File("private.key").exists()) {
            PrintWriter writer = new PrintWriter("private.key");
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
    }

    public static void main(String[] args) throws java.io.IOException {
        first();
        while(true) {
            try {
                // Accept attempted client connections
                client = socket.accept();
                if(client.getInputStream() != null) {
                    OutputStream stdin = p.getOutputStream();
                    BufferedReader bf = new BufferedReader(new InputStreamReader(client.getInputStream()));
                    formatted = request.fromJson(bf.readLine(), String[].class);
                    BufferedWriter writer = new BufferedWriter(new OutputStreamWriter(stdin));
                    // Checks if the request contains a command
                    if(!formatted.equals(null)) {
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
                            }
                            else if (formatted[0].equals("restart") && p.isAlive()) {
                                try {
                                    writer.write("stop");
                                    writer.newLine();
                                    writer.close();
                                } finally {
                                    p.destroy();
                                    first();
                                    break;
                                }
                            }
                            else if (formatted[0].equals("start") && !p.isAlive()) {
                                first();
                                break;
                            }
                        }
                        // Checks if the request contains a foreign action type
                        else {
                            // Do other thing
                        }
                    }
                }
                vote = votifier.accept();
                if(vote.getInputStream() != null) {
                    BufferedReader vbf = new BufferedReader(new InputStreamReader(vote.getInputStream()));
                    byte[] decodedBytes = vbf.readLine().getBytes();
                    PrivateKey key = readPrivateKey(new File("private.key"));
                }
                Thread.sleep(50);
            }
            catch(Exception err) {
                System.out.println(err);
            }
        }
    }
}